// import Quill from 'quill';

// import 'quill/dist/quill.snow.css';

// window.Quill = Quill;
// // document.addEventListener("DOMContentLoaded", function () {
// //     var editorElement = document.querySelector('.editor');
// //     if (editorElement) {
// //         var quill = new Quill(editorElement, {
// //             theme: 'snow'
// //         });

// //         // Simpan isi Quill ke dalam input hidden sebelum form dikirim
// //         document.querySelector('form').onsubmit = function () {
// //             document.querySelector('#quill-content').value = quill.root.innerHTML;
// //         };
// //     }
// // });


import hljs from 'highlight.js';
import 'highlight.js/styles/default.css';  // Tambahkan tema highlight.js
import Quill from 'quill';
import 'quill/dist/quill.snow.css';
import QuillResizeImage from 'quill-resize-image';

// Pastikan highlight.js tersedia untuk Quill
window.hljs = hljs;
window.Quill = Quill;
Quill.register('modules/resize', QuillResizeImage);