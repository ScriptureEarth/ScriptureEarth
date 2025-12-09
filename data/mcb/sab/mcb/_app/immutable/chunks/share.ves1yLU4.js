function i(a,r){return new File([a],r,{type:"text/plain"})}async function f(a,r,t,h=!1){let c;try{if(navigator.share){let e={title:a,text:r};if(h){c=i(r,t);const s=[c];navigator.canShare&&navigator.canShare({files:s})&&(e={...e,text:"",files:s})}await navigator.share(e);return}}catch(e){console.error("Error sharing: ",e)}const l=i(a+`

`+r,t),o=URL.createObjectURL(l),n=document.createElement("a");n.href=o,n.download=t,n.click(),URL.revokeObjectURL(o)}export{f as s};
