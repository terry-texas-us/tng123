// ===================================================================
// Author: Matt Kruse <matt@mattkruse.com>
// WWW: http://www.mattkruse.com/
// ===================================================================

ColorPicker_targetInput = null;

function ColorPicker_writeDiv() {
    document.writeln("<DIV ID=\"colorPickerDiv\" STYLE=\"position:absolute;visibility:hidden;\"> </DIV>");
}

function ColorPicker_show(anchorname) {
    this.showPopup(anchorname);
}

function ColorPicker_pickColor(color, obj) {
    obj.hidePopup();
    pickColor(color);
}

// A Default "pickColor" function to accept the color passed back from popup.
// User can over-ride this with their own function.
function pickColor(color) {
    if (ColorPicker_targetInput == null) {
        alert("Target Input is null, which means you either didn't use the 'select' function or you have no defined your own 'pickColor' function to handle the picked color!");
        return;
    }
    ColorPicker_targetInput.value = color;
}

// This function is the easiest way to popup the window, select a color, and
// have the value populate a form field, which is what most people want to do.
function ColorPicker_select(inputobj, linkname) {
    if (inputobj.type != "text" && inputobj.type != "hidden" && inputobj.type != "textarea") {
        alert("colorpicker.select: Input object passed is not a valid form input object");
        window.ColorPicker_targetInput = null;
        return;
    }
    window.ColorPicker_targetInput = inputobj;
    this.show(linkname);
}

// This function runs when you move your mouse over a color block, if you have a newer browser
function ColorPicker_highlightColor(c) {
    var thedoc = (arguments.length > 1) ? arguments[1] : window.document;
    var d = thedoc.getElementById("colorPickerSelectedColor");
    d.style.backgroundColor = c;
    d = thedoc.getElementById("colorPickerSelectedColorValue");
    d.innerHTML = c;
}

function ColorPicker() {
    var windowMode = false;
    // Create a new PopupWindow object
    if (arguments.length == 0) {
        var divname = "colorPickerDiv";
    } else if (arguments[0] == "window") {
        var divname = '';
        windowMode = true;
    } else {
        var divname = arguments[0];
    }

    if (divname != "") {
        var cp = new PopupWindow(divname);
    } else {
        var cp = new PopupWindow();
        cp.setSize(225, 250);
    }

    // Object variables
    cp.currentValue = "#fff";

    // Method Mappings
    cp.writeDiv = ColorPicker_writeDiv;
    cp.highlightColor = ColorPicker_highlightColor;
    cp.show = ColorPicker_show;
    cp.select = ColorPicker_select;

    // Code to populate color picker window
    var colors = new Array("#000", "#003", "#006", "#009", "#00c", "#00f", "#300", "#303", "#306", "#309", "#30c",
        "#30f", "#600", "#603", "#606", "#609", "#60c", "#6600FF", "#900", "#903", "#906", "#909",
        "#9900CC", "#90f", "#c00", "#CC0033", "#CC0066", "#c09", "#c0c", "#c0f", "#FF0000", "#f03", "#f06",
        "#f09", "#f0c", "#FF00FF", "#030", "#033", "#036", "#039", "#03c", "#03f", "#333300", "#333",
        "#333366", "#339", "#3333CC", "#33f", "#630", "#633", "#663366", "#639", "#63c", "#63f", "#930",
        "#933", "#936", "#939", "#93c", "#9933FF", "#c30", "#c33", "#c36", "#c39", "#c3c", "#c3f",
        "#f30", "#f33", "#f36", "#f39", "#f3c", "#FF33FF", "#060", "#063", "#066", "#006699", "#06c",
        "#0066FF", "#360", "#336633", "#366", "#369", "#36c", "#36f", "#666600", "#663", "#666", "#669",
        "#66c", "#66f", "#960", "#963", "#966", "#996699", "#96c", "#96f", "#c60", "#c63", "#c66",
        "#c69", "#CC66CC", "#c6f", "#f60", "#f63", "#FF6666", "#f69", "#f6c", "#f6f", "#090", "#009933",
        "#009966", "#099", "#09c", "#0099FF", "#390", "#393", "#396", "#399", "#39c", "#39f", "#669900",
        "#693", "#696", "#699", "#69c", "#69f", "#990", "#999933", "#996", "#999", "#99c", "#99f",
        "#CC9900", "#c93", "#c96", "#c99", "#c9c", "#c9f", "#f90", "#f93", "#f96", "#FF9999", "#f9c",
        "#f9f", "#00CC00", "#0c3", "#0c6", "#0c9", "#0cc", "#0cf", "#3c0", "#3c3", "#3c6", "#3c9",
        "#3cc", "#3cf", "#66CC00", "#6c3", "#6c6", "#6c9", "#6cc", "#6cf", "#99CC00", "#9c3", "#9c6",
        "#99CC99", "#99CCCC", "#9cf", "#CCCC00", "#cc3", "#cc6", "#cc9", "#ccc", "#ccf", "#FFCC00", "#fc3",
        "#fc6", "#fc9", "#FFCCCC", "#fcf", "#00FF00", "#0f3", "#0f6", "#0f9", "#0fc", "#0ff", "#3f0",
        "#33FF33", "#33FF66", "#33FF99", "#3fc", "#3ff", "#6f0", "#6f3", "#6f6", "#6f9", "#6fc", "#6ff",
        "#9f0", "#9f3", "#9f6", "#9f9", "#9fc", "#99FFFF", "#cf0", "#cf3", "#CCFF66", "#CCFF99", "#cfc",
        "#CCFFFF", "#ff0", "#FFFF33", "#ff6", "#ff9", "#ffc", "#fff");
    var total = colors.length;
    var width = 18;
    var cp_contents = "";
    var windowRef = (windowMode) ? "window.opener." : "";
    if (windowMode) {
        cp_contents += "<HTML><HEAD><TITLE>Select Color</TITLE><link href='../genstyle.css' rel='stylesheet'><link href='../mytngstyle.css' rel='stylesheet'></HEAD>";
        cp_contents += "<BODY MARGINWIDTH=0 MARGINHEIGHT=0 LEFTMARGIN=0 TOPMARGIN=0><CENTER>";
    }
    cp_contents += "<TABLE BORDER=1 CELLSPACING=1 CELLPADDING=0>";
    var use_highlight = (document.getElementById || document.all) ? true : false;
    for (var i = 0; i < total; i++) {
        if ((i % width) == 0) {
            cp_contents += "<TR>";
        }
        if (use_highlight) {
            var mo = 'onMouseOver="' + windowRef + 'ColorPicker_highlightColor(\'' + colors[i] + '\',window.document)"';
        } else {
            mo = "";
        }
        cp_contents += '<TD BGCOLOR="' + colors[i] + '"><FONT SIZE="-3"><A HREF="#" onClick="' + windowRef + 'ColorPicker_pickColor(\'' + colors[i] + '\',' + windowRef + 'window.popupWindowObjects[' + cp.index + ']);return false;" ' + mo + ' STYLE="text-decoration:none;">&nbsp;&nbsp;&nbsp;</A></FONT></TD>';
        if (((i + 1) >= total) || (((i + 1) % width) == 0)) {
            cp_contents += "</TR>";
        }
    }
    // If the browser supports dynamically changing TD cells, add the fancy stuff
    if (document.getElementById) {
        var width1 = Math.floor(width / 2);
        var width2 = width = width1;
        cp_contents += "<TR><TD COLSPAN='" + width1 + "' BGCOLOR='#fff' ID='colorPickerSelectedColor'>&nbsp;</TD><TD COLSPAN='" + width2 + "' ALIGN='CENTER' ID='colorPickerSelectedColorValue'><font size='3'>#FFFFFF</font></TD></TR>";
    }
    cp_contents += "</TABLE>";
    if (windowMode) {
        cp_contents += "</CENTER></BODY></HTML>";
    }
    // end populate code

    // Write the contents to the popup object
    cp.populate(cp_contents + "\n");
    // Move the table down a bit so you can see it
    cp.offsetY = 25;
    cp.autoHide();
    return cp;
}
