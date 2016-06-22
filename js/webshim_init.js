webshim.setOptions("forms", {
	lazyCustomMessages: true,
	customDatalist: "auto",
	list: {
		"filter": "^"
	}
});
webshim.setOptions("forms-ext", {
	"widgets": {
		"startView": 2,
		"openOnFocus": true,
		"calculateWidth": false
	}
});
webshim.polyfill('forms forms-ext');