# Someday browsers will all handle svg sensibly and we can then just
# serve it up directly

all: hr.png stripes.png stripes-dark.png

.svg.png:
	rsvg-convert $< > $@

.SUFFIXES: .svg .png
