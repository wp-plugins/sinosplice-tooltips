/*javascript for Bubble Tooltips by Alessandro Fulciniti
- http://pro.html.it - http://web-graphics.com */

/* Some modifications made for Sinosplice Tooltips. */

function enableSinospliceTooltips(id) {
   var links,i,h;
   if (!document.getElementById || !document.getElementsByTagName)
      return;
   h = document.createElement("span");
   h.id = "btc";
   h.setAttribute("id","btc");
   h.style.position = "absolute";
   document.getElementsByTagName("body")[0].appendChild(h);
   if (id == null)
      links = st_getElementsByClass(spanclass,document);
   else
      links = st_getElementsByClass(spanclass,document,id);
   for (i=0; i<links.length; i++) {
      st_Prepare(links[i]);
   }
}

function st_Prepare(el) {
   var st_tooltip,t,b,s,l;
   t = el.getAttribute("title");
   if (t == null || t.length == 0)
      t = "Undefined";
   el.removeAttribute("title");
   st_tooltip = st_CreateEl("span","st_tooltip");
   s = st_CreateEl("span","top");
   if (originaltext == "yes")
      l = el.innerHTML;
   else
      l = "";
   s.appendChild(document.createTextNode(l));
   st_tooltip.appendChild(s);
   b = st_CreateEl("b","bottom");
   if (toneconversion == "yes2")
      t = addtones(t);
   b.appendChild(document.createTextNode(t));
   st_tooltip.appendChild(b);
   st_setOpacity(st_tooltip);
   el.tooltip = st_tooltip;
   el.onmouseover = st_showTooltip;
   el.onmouseout = st_hideTooltip;
   el.onmousemove = st_Locate;
}

function st_showTooltip(e) {
   document.getElementById("btc").appendChild(this.tooltip);
   st_Locate(e);
}

function st_hideTooltip(e) {
   var d = document.getElementById("btc");
   if (d.childNodes.length > 0) d.removeChild(d.firstChild);
}

function st_setOpacity(el) {
   el.style.filter = "alpha(opacity:95)";
   el.style.KHTMLOpacity = "0.95";
   el.style.MozOpacity = "0.95";
   el.style.opacity = "0.95";
}

function st_CreateEl(t,c) {
   var x = document.createElement(t);
   x.className = c;
   x.style.display = "block";
   return(x);
}

function st_Locate(e) {
   var posx = 0, posy = 0;
   if (e == null)
      e = window.event;
   if (e.pageX || e.pageY) {
      posx = e.pageX;
      posy = e.pageY;
   } else if (e.clientX || e.clientY) {
      if (document.documentElement.scrollTop) {
         posx = e.clientX+document.documentElement.scrollLeft;
         posy = e.clientY+document.documentElement.scrollTop;
      } else {
         posx = e.clientX+document.body.scrollLeft;
         posy = e.clientY+document.body.scrollTop;
      }
   }
   document.getElementById("btc").style.top = (posy+10) + "px";
   document.getElementById("btc").style.left = (posx-20) + "px";
}

function st_getElementsByClass(searchClass,node,tag) {
   var classElements = new Array();
   if (node == null)
      node = document;
   if (tag == null)
      tag = '*';
   var els = node.getElementsByTagName(tag);
   var elsLen = els.length;
   var pattern = new RegExp("(^|\\\\s)" + searchClass + "(\\\\s|$)");
   for (i=0,j=0; i<elsLen; i++) {
      if (pattern.test(els[i].className)) {
         classElements[j] = els[i];
         j++;
      }
   }
   return classElements;
}
