var selects = [];
var selidx = 0;
LITBox = function (url, options) {
    this.url = url;
    this.options = {
        width: 700,
        height: 500,
        type: 'window',
        func: null,
        onremove: null,
        draggable: true,
        resizable: true,
        overlay: true,
        opacity: 1,
        left: false,
        top: false,
        doneLoading: null
    };
    const winwidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
    jQuery.extend(this.options, options || {});
    if (winwidth < this.options.width) this.options.width = winwidth - 35;
    this.setup();
}
LITBox.prototype = {
    setup: function () {
        var self = this;
        jQuery(document).ready(function () {
            self._setup();
        });
    },
    _setup: function () {
        var self = this;
        const $searchDropSelection = jQuery('#searchdrop');
        if ($searchDropSelection.length) $searchDropSelection.hide();
        this.rn = (Math.floor(Math.random() * 100000000 + 1));
        this.getWindow();
        switch (this.options.type) {
            case 'window' :
                const tempvar = this.getAjax(this.url);
                this.d4.innerHTML = tempvar;
                break;
            case 'alert' :
                this.d4.innerHTML = this.url;
                break;
            case 'confirm' :
                this.d4.innerHTML = '<p>' + this.url + '</p>';
                this.button_y = document.createElement('input');
                this.button_y.type = 'button';
                this.button_y.value = 'Yes';
                this.d4.appendChild(this.button_y);
                this.button_y.d = this.d;
                this.button_y.d2 = this.d2;
                this.button_y.temp = this.options.func;
                this.button_y.onclick = this.remove;
                this.button_n = document.createElement('input');
                this.button_n.type = 'button';
                this.button_n.value = 'No';
                this.d4.appendChild(this.button_n);
                this.button_n.d = this.d;
                this.button_n.d2 = this.d2;
                this.button_n.onclick = this.remove;
        }
        this.display();
    },
    getWindow: function () {
        this.over = null;
        if (this.options.overlay === true) {
            this.d = document.createElement('div');
            document.body.appendChild(this.d);
            this.d.className = 'LB_overlay';
            this.d.id = 'LB_overlay';
            this.d.style.display = 'block';
        }
        this.d2 = document.createElement('div');
        document.body.appendChild(this.d2);
        this.d2.className = 'LB_window';
        this.d2.id = 'LB_window';
        this.d2.style.height = parseInt(this.options.height) + 'px';
        this.d2.style.zIndex = '101';
        this.d3 = document.createElement('div');
        this.d2.appendChild(this.d3);
        this.d3.className = 'LB_closeAjaxWindow';
        this.d3.d2 = this.d2;
        this.d3.over = this.over;
        this.d3.options = this.options;
        if (this.options.draggable)
            $(this.d2).draggable({handle: '.LB_closeAjaxWindow'}).resizable();
        this.close = document.createElement('a');
        this.d3.appendChild(this.close);
        this.d3.style.width = parseInt(this.options.width) + 'px';
        this.close.d = this.d;
        this.close.d2 = this.d2;
        this.close.href = '#';
        this.close.onclick = this.remove;
        this.close.innerHTML = '<img src="' + closeimg + '" alt="">';
        this.close.id = 'LB_close';
        this.close.onremove = this.options.onremove;
        this.d3text = document.createElement('div');
        this.d3text.id = 'LB_titletext';
        this.d3text.className = 'fieldname';
        if (this.options.title) this.d3text.innerHTML = '<strong>' + this.options.title + '</strong>';
        this.d3.appendChild(this.d3text);
        this.d4 = document.createElement('div');
        this.d4.className = 'LB_content';
        this.d4.style.height = parseInt(this.options.height) + 'px';
        this.d4.style.width = parseInt(this.options.width) + 'px';
        this.d2.appendChild(this.d4);
        this.clear = document.createElement('div');
        this.d2.appendChild(this.clear);
        this.clear.style.clear = 'both';
        if (this.options.overlay === true) {
            this.d.d = this.d;
            this.d.d2 = this.d2;
        }
    },
    display: function () {
        jQuery(this.d2).css('opacity', 0);
        this.position();
        jQuery(this.d2).animate({opacity: this.options.opacity}, 200, this.options.doneLoading);
    },
    position: function () {
        var de = document.documentElement;
        var w = self.innerWidth || (de && de.clientWidth) || document.body.clientWidth;
        var h = self.innerHeight || (de && de.clientHeight) || document.body.clientHeight;
        let yScroll = 0;
        if (window.innerHeight) {
            yScroll = window.innerHeight;
            if (window.scrollMaxY)
                yScroll += window.scrollMaxY;
        }
        if (document.body.scrollHeight >= document.body.offsetHeight && document.body.scrollHeight > yScroll) { // all but Explorer Mac
            yScroll = document.body.scrollHeight + 30;
        }
        if (document.documentElement.clientHeight && document.documentElement.clientHeight > yScroll) {
            yScroll = document.documentElement.clientHeight
        }
        if (!yScroll) { // Explorer Mac...would also work in Explorer 6 Strict, Mozilla and Safari
            yScroll = document.body.offsetHeight;
        }
        this.d2.style.width = this.options.width + 'px';
        this.d2.style.display = 'block';
        if (!this.options.left || this.options.left < 0) {
            this.d2.style.left = ((w - this.options.width) / 2) + "px";
        } else {
            this.d2.style.left = parseInt(this.options.left) + 'px';
        }
        const pagesize = this.getPageSize();
        var arrayPageScroll = this.getPageScrollTop();
        if (!this.options.top || this.options.top < 0) {
            var newtop = arrayPageScroll[1] + ((pagesize[1] - this.d2.offsetHeight) / 2);
            this.d2.style.top = newtop > 0 ? newtop + "px" : "0px";
        } else {
            this.d2.style.top = parseInt(this.options.top) + 'px';
        }
        if (this.d) this.d.style.height = yScroll + "px";
    },
    remove: function () {
        if (this.temp) this.temp();
        var d2 = jQuery(this.d2);
        var onremove = this.onremove;
        d2.animate({opacity: 0}, 200, function () {
            d2.remove()
        });
        if (this.d) {
            var d = jQuery(this.d);
            d.animate({opacity: 0}, 200, function () {
                d.remove();
                if (onremove) onremove();
            });
        }
        return false;
    },
    parseQuery: function (query) {
        var Params = new Object();
        if (!query) return Params; // return empty object
        const Pairs = query.split(/[;&]/);
        for (let i = 0; i < Pairs.length; i++) {
            const KeyVal = Pairs[i].split('=');
            if (!KeyVal || KeyVal.length != 2) continue;
            const key = unescape(KeyVal[0]);
            let val = unescape(KeyVal[1]);
            val = val.replace(/\+/g, ' ');
            Params[key] = val;
        }
        return Params;
    },
    getPageScrollTop: function () {
        let yScrolltop;
        if (self.pageYOffset) {
            yScrolltop = self.pageYOffset;
        } else if (document.documentElement && document.documentElement.scrollTop) {    // Explorer 6 Strict
            yScrolltop = document.documentElement.scrollTop;
        } else if (document.body) {// all other Explorers
            yScrolltop = document.body.scrollTop;
        }
        return ['', yScrolltop];
    },
    getPageSize: function () {
        const de = document.documentElement;
        const w = self.innerWidth || (de && de.clientWidth) || document.body.clientWidth;
        const h = self.innerHeight || (de && de.clientHeight) || document.body.clientHeight;
        return [w, h];
    },
    getAjax: function (url) {
        let xmlhttp = false;
        if (!xmlhttp && typeof XMLHttpRequest != 'undefined') xmlhttp = new XMLHttpRequest();
        if (xmlhttp.overrideMimeType) xmlhttp.overrideMimeType('text/xml');
        if (url !== "") {
            xmlhttp.open("GET", url, false);
            xmlhttp.send(null);
            return xmlhttp.responseText;
        }
    }
}

function openFind(form, findscript) {
    const params = jQuery.param(form);
    const $findSpinSelection = jQuery('#findspin');
    if ($findSpinSelection.length) jQuery('#findspin').show();
    jQuery.ajax({
        url: findscript,
        data: params,
        dataType: 'html',
        success: function (req) {
            jQuery('#findresults').html(req);
            if ($findSpinSelection.length) jQuery('#findspin').hide();
            jQuery('#finddiv').toggle(200, function () {
                jQuery('#findresults').toggle(200);
            });
        }
    });
    return false;
}

function reopenFindForm() {
    jQuery('#findresults').toggle(200, function () {
        clearForm(document.findform1);
        jQuery('#finddiv').toggle(200);
    });
}

function clearForm(form) {
    jQuery(form).children(':input').each(function (index, element) {
        if (element.type === 'text') element.value = '';
    });
}

function openHelp(filename) {
    let newwindow = window.open(filename, 'newwindow', 'height=700, width=800, resizable=yes, scrollbars=yes');
    newwindow.focus();
    return false;
}
