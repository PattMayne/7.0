const input = document.querySelector('input[type="file"]')
const form = input.closest('form')
const convertButton = document.querySelector('#convert_btn')
const saveButton = document.querySelector('#save_btn')
const saveContainer = document.querySelector('#save_container')
const statusElement = document.querySelector('#status')
const customFieldsCheckbox = document.querySelector('#custom_fields_only')
let customFieldsEnabled = () => customFieldsCheckbox.checked

const MAX_UPLOAD_BYTES = 25 * 1024 * 1024
const MAX_KML_BYTES = 50 * 1024 * 1024
const MAX_ARCHIVE_ENTRIES = 1000

const KML_NAMESPACES = new Set([
  'http://www.opengis.net/kml/2.2',
  'http://earth.google.com/kml/2.1',
  'http://earth.google.com/kml/2.0'
])

const GEOMETRY_NAMES = new Set([
  'Point',
  'LineString',
  'LinearRing',
  'Polygon',
  'MultiGeometry',
  'Model',
  'Track',
  'MultiTrack'
])

const BASE_COLUMNS = [
  'source_kml',
  'id',
  'name',
  'description',
  'layer',
  'geometry_type',
  'longitude',
  'latitude',
  'altitude',
  'geometry_kml',
  'timestamp',
  'begin',
  'end',
  'style_url'
]

const CUSTOM_BASE_COLUMNS = [
  'name'
]

let busy = false
let csvBlob = null
let csvFilename = ''


const setStatus = message => {
  statusElement.textContent = message
}


const resetResult = () => {
  csvBlob = null
  saveContainer.style.display = 'none'
}


const setBusy = value => {
  busy = value
  input.disabled = value
  convertButton.setAttribute('aria-disabled', String(value))
  convertButton.textContent = value ? 'CONVERTING…' : 'CONVERT'
}


const fail = message => {
  throw new Error(message)
}


// Only read actual KML elements, not similarly named custom XML.
const isKmlElement = element =>
  KML_NAMESPACES.has(element.namespaceURI)

const childrenNamed = (element, name) =>
  [...element.children].filter(child =>
    child.localName === name && isKmlElement(child)
  )


const childNamed = (element, name) =>
  childrenNamed(element, name)[0]


const descendantsNamed = (element, name) =>
  [...element.getElementsByTagName('*')].filter(child =>
    child.localName === name && isKmlElement(child)
  )


const childText = (element, name) =>
  childNamed(element, name)?.textContent.trim() ?? ''

const nestedText = (element, parentName, name) => {
  const parent = childNamed(element, parentName)

  return parent ? childText(parent, name) : ''
}


const getLayer = placemark => {
  const names = []

  for (
    let parent = placemark.parentElement;
    parent;
    parent = parent.parentElement
  ) {
    if (
      parent.localName === 'Folder' &&
      isKmlElement(parent) &&
      childText(parent, 'name')
    ) {
      names.unshift(childText(parent, 'name'))
    }
  }

  return names.join(' / ')
}


const getCustomFields = placemark => {
  const extendedData = childNamed(placemark, 'ExtendedData')

  if (!extendedData) return {}

  const entries = [
    ...descendantsNamed(extendedData, 'Data').map(element => [
      element.getAttribute('name'),
      childText(element, 'value')
    ]),
    ...descendantsNamed(extendedData, 'SimpleData').map(element => [
      element.getAttribute('name'),
      element.textContent.trim()
    ])
  ]

  // Keep repeated fields instead of silently overwriting them.
  return entries
    .filter(([name]) => nameIsOkay(name))
    .reduce((fields, [name, value]) => {
      const key = `custom:${name}`

      fields[key] = Object.hasOwn(fields, key)
        ? `${fields[key]}\n${value}`
        : value

      return fields
    }, {})
}


const nameIsOkay = name => {
  if (customFieldsEnabled && name.includes('Location')) {
    return false
  }

  // Avoid names that look like formulas or CSV injection.
  return !/^\s*[=+\-@]/.test(name)
}


const parseCoordinate = tuple => {
  const parts = tuple.split(',')

  if (
    parts.length < 2 ||
    parts.length > 3 ||
    parts.some(part => !part.trim())
  ) {
    fail(`Invalid coordinate: ${tuple}`)
  }

  const values = parts.map(Number)
  const [longitude, latitude] = values

  if (
    !values.every(Number.isFinite) ||
    longitude < -180 ||
    longitude > 180 ||
    latitude < -90 ||
    latitude > 90
  ) {
    fail(`Coordinate outside the supported range: ${tuple}`)
  }

  return values
}


const validateCoordinates = placemark => {
  descendantsNamed(placemark, 'coordinates').forEach(element => {
    const text = element.textContent.trim()

    if (!text) fail('A geometry contains empty coordinates.')

    const tuples = text.split(/\s+/)
    tuples.forEach(parseCoordinate)

    if (
      element.parentElement.localName === 'Point' &&
      tuples.length !== 1
    ) {
      fail('A Point must contain exactly one coordinate.')
    }
  })
}


const placemarkToRow = (placemark, sourceName) => {
  validateCoordinates(placemark)

  const geometries = [...placemark.children].filter(element =>
    GEOMETRY_NAMES.has(element.localName) &&
    (
      isKmlElement(element) ||
      element.namespaceURI === 'http://www.google.com/kml/ext/2.2'
    )
  )


  // Separate latitude/longitude columns apply only to a simple Point.
  const point = geometries.length === 1 &&
    geometries[0].localName === 'Point'
      ? geometries[0]
      : null

  const coordinates = point ? childText(point, 'coordinates') : ''

  if (point && !coordinates) {
    fail('A Point is missing its coordinates.')
  }

  const [longitude = '', latitude = '', altitude = ''] =
    coordinates ? parseCoordinate(coordinates) : []

  const serializer = new XMLSerializer()



  return customFieldsEnabled ? {
      name: childText(placemark, 'name'),
    ...getCustomFields(placemark)
  } : {
    name: childText(placemark, 'name'),
    description: childText(placemark, 'description'),
    layer: getLayer(placemark),
    geometry_type: geometries.map(element => element.localName).join(', '),
    longitude,
    latitude,
    altitude,

    // Preserve routes, polygon rings and multi-geometries as XML.
    geometry_kml: geometries
      .map(element => serializer.serializeToString(element))
      .join('\n'),

    timestamp: nestedText(placemark, 'TimeStamp', 'when'),
    begin: nestedText(placemark, 'TimeSpan', 'begin'),
    end: nestedText(placemark, 'TimeSpan', 'end'),
    style_url: childText(placemark, 'styleUrl'),
    ...getCustomFields(placemark)
  } 
}

const parseKml = ({ name, text }) => {
  if (/<!DOCTYPE|<!ENTITY/i.test(text)) {
    fail(`${name}: DTDs and custom entities are not supported.`)
  }

  const document = new DOMParser().parseFromString(
    text,
    'application/xml'
  )

  if (document.getElementsByTagName('parsererror').length) {
    fail(`${name}: Invalid XML.`)
  }

  const root = document.documentElement

  if (root.localName !== 'kml' || !isKmlElement(root)) {
    fail(`${name}: Expected a supported KML document.`)
  }

  return descendantsNamed(root, 'Placemark')
    .map(placemark => placemarkToRow(placemark, name))
}

// Decode typical UTF-8 KML and BOM-marked UTF-16 files.
const decodeXml = bytes => {
  const encoding =
    bytes[0] === 0xff && bytes[1] === 0xfe ? 'utf-16le' :
    bytes[0] === 0xfe && bytes[1] === 0xff ? 'utf-16be' :
    'utf-8'

  return new TextDecoder(encoding, { fatal: true }).decode(bytes)
}

const readDocuments = async file => {
  const extension = file.name.split('.').pop().toLowerCase()

  if (!['kml', 'kmz'].includes(extension)) {
    fail('Please select a .kml or .kmz file.')
  }

  if (!file.size) fail('The selected file is empty.')

  if (file.size > MAX_UPLOAD_BYTES) {
    fail('The upload limit is 25 MiB.')
  }

  const bytes = new Uint8Array(await file.arrayBuffer())

  if (extension === 'kml') {
    return [{ name: file.name, text: decodeXml(bytes) }]
  }

  if (typeof JSZip === 'undefined') {
    fail('JSZip did not load. Check the script include.')
  }

  if (
    bytes[0] !== 0x50 ||
    bytes[1] !== 0x4b ||
    bytes[2] !== 0x03 ||
    bytes[3] !== 0x04
  ) {
    fail('The KMZ does not have the expected ZIP signature.')
  }

  const archive = await JSZip.loadAsync(bytes)
  const entries = Object.values(archive.files)

  if (entries.length > MAX_ARCHIVE_ENTRIES) {
    fail('The archive contains too many entries.')
  }

  const kmlEntries = entries.filter(entry =>
    !entry.dir && /\.kml$/i.test(entry.name)
  )

  if (!kmlEntries.length) {
    fail('The KMZ contains no KML files.')
  }

  const documents = []
  let totalBytes = 0

  // Extract sequentially rather than decompressing every file at once.
  for (const entry of kmlEntries) {
    const content = await entry.async('uint8array')
    totalBytes += content.byteLength

    if (totalBytes > MAX_KML_BYTES) {
      fail('Extracted KML exceeds the 50 MiB limit.')
    }

    documents.push({
      name: entry.name,
      text: decodeXml(content)
    })
  }

  return documents
}

const escapeCsv = value => {
  const text = String(value ?? '')

  const isNumericText =
    /^[+-]?(?:\d+(?:\.\d*)?|\.\d+)(?:[eE][+-]?\d+)?$/.test(text) &&
    Number.isFinite(Number(text))

  const needsProtection =
    typeof value === 'string' &&
    !isNumericText &&
    (/^\s*[=+\-@]/.test(text) || /^[\t\r\n]/.test(text))

  const safeText = needsProtection ? `'${text}` : text

  return `"${safeText.replace(/"/g, '""')}"`
}

const generateCsv = rows => {
  const customColumns = [...new Set(
    rows.flatMap(row =>
      Object.keys(row).filter(key => key.startsWith('custom:'))
    )
  )].sort()

  const columns = customFieldsEnabled
    ? [...CUSTOM_BASE_COLUMNS, ...customColumns]
    : [...BASE_COLUMNS, ...customColumns]

  return [
    columns.map(escapeCsv).join(','),
    ...rows.map(row =>
      columns.map(column => escapeCsv(row[column])).join(',')
    )
  ].join('\r\n')
}

const convert = async event => {
  event.preventDefault()
  if (busy) return

  customFieldsEnabled = customFieldsCheckbox.checked

  resetResult()
  setBusy(true)

  try {
    const file = input.files[0]

    if (!file) fail('Select a KMZ or KML file first.')

    setStatus('Reading and checking file…')

    const documents = await readDocuments(file)
    const rows = documents.flatMap(parseKml)

    if (!rows.length) {
      fail('No placemarks were found.')
    }

    const csv = generateCsv(rows)

    // BOM helps spreadsheet applications recognize UTF-8.
    csvBlob = new Blob(['\uFEFF', csv], {
      type: 'text/csv;charset=utf-8'
    })

    csvFilename = file.name.replace(/\.(kml|kmz)$/i, '') + '.csv'

    // An empty string would not override display:none in your stylesheet.
    saveContainer.style.display = 'block'

    setStatus(`Converted ${rows.length} placemarks. Click SAVE CSV.`)
  } catch (error) {
    resetResult()
    setStatus(`Conversion failed: ${error.message}`)
  } finally {
    setBusy(false)
  }
}

const saveCsv = async event => {
  event.preventDefault()
  if (!csvBlob) return

  try {
    if (window.isSecureContext && 'showSaveFilePicker' in window) {
      const handle = await window.showSaveFilePicker({
        suggestedName: csvFilename,
        types: [{
          description: 'CSV spreadsheet',
          accept: { 'text/csv': ['.csv'] }
        }]
      })

      const writable = await handle.createWritable()
      await writable.write(csvBlob)
      await writable.close()

      setStatus('CSV saved.')
      return
    }

    const url = URL.createObjectURL(csvBlob)
    const link = document.createElement('a')

    link.href = url
    link.download = csvFilename
    document.body.appendChild(link)
    link.click()
    link.remove()

    setTimeout(() => URL.revokeObjectURL(url), 60_000)
    setStatus('CSV download requested.')
  } catch (error) {
    setStatus(
      error.name === 'AbortError'
        ? 'Save cancelled. Click SAVE CSV to try again.'
        : `Saving failed: ${error.message}`
    )
  }
}

statusElement.setAttribute('role', 'status')
resetResult()

convertButton.addEventListener('click', convert)
form.addEventListener('submit', convert)
saveButton.addEventListener('click', saveCsv)

input.addEventListener('change', () => {
  resetResult()
  setStatus('File selected. Press CONVERT.')
})