from PIL import Image

img = Image.open("azul.jpg")
pixels = img.load()
w, h = img.size

for y in range(h):
    for x in range(w):
        b = pixels[x, y][2]
        if b != 0:
            print(b)
