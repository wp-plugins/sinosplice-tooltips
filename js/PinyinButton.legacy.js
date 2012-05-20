      if (wpstToolbar = document.getElementById("ed_toolbar")) {
         var wpstNum = edButtons.length;
         edButtons[wpstNum] = new edButton('wpst_quicktag','pinyin','','','');
         wpstToolbar.innerHTML +=
            '<input type="button" value="pinyin"' +
            ' onclick="processPinyin();"' +
            ' class="ed_button"' +
            ' title="Sinosplice Tooltips"' +
            ' id="wpst_quicktag"/>';
      }
