/**
 * Misc utility functions used modules.
 */

// Detects the browser locale for Date translations.
const locale = window.evrdm && window.evrdm.locale
	? window.evrdm.locale
	: (navigator.languages && navigator.languages.length)
		? navigator.languages[0]
		: navigator.language
			? navigator.language
			: 'en';

// Date formatter with php-compatible format syntax
export const formatDate = (format, date) => {
	if (format === undefined) {
		format = 'Y-m-d'
	}

	if (date === undefined) {
		// No date specified means "now"
		date = new Date()
	} else if (!isNaN(date) && typeof date !== 'object') {
		// Treat integers as PHP timestamps.
		date = new Date(date * 1000)
	} else if (typeof date === 'string') {
		// Strings are date strings, e.g. '2019-06-01'
		date = new Date(date)
	}

	const hour24 = date.getHours()
	const hour12 = (date.getHours() % 12) || 12

	// Define all known date placeholders.
	const parts = {
		Y: date.getFullYear().toString(),
		y: ('00' + (date.getYear() - 100)).toString().slice(-2),
		m: ('0' + (date.getMonth() + 1)).toString().slice(-2),
		n: (date.getMonth() + 1).toString(),
		d: ('0' + date.getDate()).toString().slice(-2),
		j: date.getDate().toString(),
		H: ('0' + hour24).toString().slice(-2),
		h: ('0' + hour12).toString().slice(-2),
		G: hour24.toString(),
		g: hour12.toString(),
		a: hour24 >= 12 && hour24 < 24 ? 'pm' : 'am',
		A: hour24 >= 12 && hour24 < 24 ? 'PM' : 'AM',
		i: ('0' + date.getMinutes()).toString().slice(-2),
		s: ('0' + date.getSeconds()).toString().slice(-2),
		S: ['st','nd','rd',,,,,,,,,,,,,,,,,,'st','nd','rd',,,,,,,,'st'][date.getDate()-1] || 'th',
		w: date.getDay(),
		N: date.getDay() > 0 ? date.getDay() : 7,
		D: date.toLocaleString(locale, { weekday: "short" }),
		l: date.toLocaleString(locale, { weekday: "long" }),
		M: date.toLocaleString(locale, { month: "short" }),
		F: date.toLocaleString(locale, { month: "long" })
	}
	const modifiers = Object.keys(parts).join('')
	const reDate = new RegExp('[' + modifiers + ']', 'g')

	return format.replace(reDate, $0 => parts[$0])
}
