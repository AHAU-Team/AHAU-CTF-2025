**Autor:** Soqui

##### Descripción del texto 
Se nos proporciona una imagen aparentemente normal: `azul.jpg` 
![[azul.jpg]]
##### Análisis inicial

Visualmente, la imagen parece ser una foto común, sin texto escondido ni distorsiones notables.

Usamos herramientas clásicas de esteganografía para verificar si hay algo extraño:
- `strings`, `binwalk`, `steghide` → no revelan nada útil.

En los metadatos (Exif) aparece el siguiente mensaje:
```
$ exiftool azul.jpg

--REDACTED--
Copyright                       : Solo ve el azul :)
--REDACTED--

```

##### Hipótesis

El mensaje claramente sugiere que la información se encuentra oculta en el canal azul (B) de la imagen, lo cual es común en técnicas de esteganografía basada en color.

##### Exploración del canal azul

Usaremos Python y Pillow para cargar la imagen y visualizar si tiene algo en el canal azul (B)
```python3
from PIL import Image
import numpy as np

img = Image.open("azul.jpg")
arr = np.array(img)

# Extraemos solo el canal azul
blue = arr[:, :, 2]

# ¿Dónde hay datos?
nonzero = np.argwhere(blue != 0)
print(f"Píxeles azules con datos: {len(nonzero)}")
```

Vemos que tiene 19 pixeles azules 

Haremos un script para ver los valores del azul
```
from PIL import Image

img = Image.open("azul.jpg")
pixels = img.load()
w, h = img.size

for y in range(h):
    for x in range(w):
        b = pixels[x, y][2]
        if b != 0:
            print(b)
```
Nos da como resultado `65 72 65 85 123 115 48 108 48 95 52 122 117 108 95 98 114 48 125` que a simple vista parecen ser valores de ASCII

Asi que los pasamos a ASCII
```
nums = [65, 72, 65, 85, 123, 115, 48, 108, 48, 95, 52, 122, 117, 108, 95, 98, 114, 48, 125]
flag = "".join(chr(n) for n in nums)
print(flag)
```

Termina dandonos la flag
`AHAU{s0l0_4zul_br0}`