from PIL import Image
import numpy as np

img = Image.open("azul.jpg")
arr = np.array(img)

# Extraemos solo el canal azul
blue = arr[:, :, 2]

# ¿Dónde hay datos?
nonzero = np.argwhere(blue != 0)
print(f"Píxeles azules con datos: {len(nonzero)}")
