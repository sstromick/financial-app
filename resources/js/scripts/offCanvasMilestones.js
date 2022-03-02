import $ from 'jquery';
window.$ = window.jQuery = $;

window.addEventListener('load', (event) => {
    start(event);
});

function start(event) {
    'use strict';
    
    $('#off-canvas').on('opened.zf.offCanvas', function(event) {
        // Prevent the document from scrolling 
        // when user scrolls the progress nav
       document.documentElement.style.overflow = "hidden";
    });
    
    $('#off-canvas').on('close.zf.offCanvas', function(event) {
        document.documentElement.style.overflow = "";
     });
    
     
     let milestones = document.querySelectorAll('.milestone');
     for(let milestone of milestones) {
         milestone.addEventListener('click', (event) => {
             $('#off-canvas').foundation('close', (event) => {});
         });
     }
     
}