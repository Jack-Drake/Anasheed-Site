function getParameterByName(name, url = window.location.href) {
    name = name.replace(/[\[\]]/g, '\\$&');
    var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, ' '));
}

var url = "../anasheed_pdf/anasheed_" + getParameterByName("songnumber") + ".pdf";

var thePdf = null;
var scale = .5;

pdfjsLib.getDocument(url).promise.then(function(pdf) {
    thePdf = pdf;
    viewer = document.getElementById('pdf-viewer');

    for(page = 1; page <= pdf.numPages; page++) {
        div = document.createElement('div');
        div.style.textAlign = "center";
        canvas = document.createElement("canvas");    
        canvas.className = 'pdf-page-canvas';
        canvas.style.padding = "10px";
        viewer.appendChild(div);
        div.appendChild(canvas);
        renderPage(page, canvas);
    }
}).catch(err => {
    //display error
    const div = document.createElement('div');
    div.className = 'error';
    div.appendChild(document.createTextNode(err.message));
    document.querySelector('body').insertBefore(div, document.getElementById('pdf-viewer'));
    
    //remove the top bar
    document.querySelector('.top-bar').style.display = 'none';
});

function renderPage(pageNumber, canvas) {
    thePdf.getPage(pageNumber).then(function(page) {
      viewport = page.getViewport({scale});
      canvas.height = viewport.height;
      canvas.width = viewport.width;          
      page.render({canvasContext: canvas.getContext('2d'), viewport});
});
}