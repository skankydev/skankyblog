
var wysihtmlParserRules = {
	"classes": {
		"text-color-black":1,
		"text-color-gray":1,
		"text-color-green":1,
		"text-color-red":1,
		"text-color-blue":1,
		"post-img-left":1,
		"post-img-default":1,
		"post-img-right":1
	},
	"tags": {
		"strong": {},
		"b":      {},
		"i":      {},
		"em":     {},
		"br":     {},
		"p":      {},
		"div":    {},
		"span":   {},
		"ul":     {},
		"ol":     {},
		"li":     {},
		"h1":     {},
		"h2":     {},
		"h3":     {},
		"pre":    {},
		"code":   {},
		"a": {
			"check_attributes": {
				"target": "any",
				"href": "url"
			},
			"set_attributes": {
				"rel": "nofollow"
			}
		},
		"img": {
			"check_attributes": {
				"alt": "alt",
				"src": "url",
				"height": "dimension",
				"width": "dimension"
			},
			"add_class": {
				"align": "align_img"
			}
		},
	}
};
