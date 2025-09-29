const express = require('express');
const fs = require('fs');
const path = require('path');

const app = express();
const PORT = 3000;

app.use(express.static('public'));
app.use(express.urlencoded({ extended: true }));
app.use(express.json());

app.post('/search', (req, res) => {
    let filename = req.body.filename;
    let warning = null;
    
    if (filename.toString().length >= 10) {
        filename = filename.slice(0, 10);
        warning = 'El nombre del archivo es muy largo, solo se tomaron los primeros 10 caracteres';
    }
    
    const filePath = __dirname + '/files/' + filename;
    
    try {
        const content = fs.readFileSync(filePath, 'utf8');
        res.json({ 
            success: true, 
            filename: filename,
            content: content,
            warning: warning
        });
    } catch (error) {
        res.json({ 
            success: false, 
            error: 'Archivo no encontrado',
            warning: warning
        });
    }
});

app.listen(PORT, () => {
    console.log(`Servidor corriendo en http://localhost:${PORT}`);
});