// ===================================================================
// Author: Matt Kruse <matt@mattkruse.com>
// WWW: http://www.mattkruse.com/
// ===================================================================

ColorPicker_targetInput = null;

function ColorPicker_writeDiv() {
    document.writeln("<div id='colorPickerDiv' style='position: absolute; visibility: hidden;'> </div>");
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
    if (inputobj.type !== "text" && inputobj.type !== "hidden" && inputobj.type !== "textarea") {
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
    let cp;
    let divname;
    let windowMode = false;

    if (arguments.length === 0) {
        divname = "colorPickerDiv";
    } else if (arguments[0] === "window") {
        divname = '';
        windowMode = true;
    } else {
        divname = arguments[0];
    }
    if (divname !== "") {
        cp = new PopupWindow(divname);
    } else {
        cp = new PopupWindow();
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
    const colors = [
        "#000", "#003", "#006", "#009", "#00c", "#00f", "#300", "#303", "#306", "#309", "#30c", "#30f", "#600", "#603", "#606", "#609", "#60c", "#60f",
        "#900", "#903", "#906", "#909", "#90c", "#90f", "#c00", "#c03", "#c06", "#c09", "#c0c", "#c0f", "#f00", "#f03", "#f06", "#f09", "#f0c", "#f0f",
        "#030", "#033", "#036", "#039", "#03c", "#03f", "#330", "#333", "#336", "#339", "#33c", "#33f", "#630", "#633", "#636", "#639", "#63c", "#63f",
        "#930", "#933", "#936", "#939", "#93c", "#93f", "#c30", "#c33", "#c36", "#c39", "#c3c", "#c3f", "#f30", "#f33", "#f36", "#f39", "#f3c", "#f3f",
        "#060", "#063", "#066", "#069", "#06c", "#06f", "#360", "#363", "#366", "#369", "#36c", "#36f", "#660", "#663", "#666", "#669", "#66c", "#66f",
        "#960", "#963", "#966", "#969", "#96c", "#96f", "#c60", "#c63", "#c66", "#c69", "#c6c", "#c6f", "#f60", "#f63", "#f66", "#f69", "#f6c", "#f6f",
        "#090", "#093", "#096", "#099", "#09c", "#09f", "#390", "#393", "#396", "#399", "#39c", "#39f", "#690", "#693", "#696", "#699", "#69c", "#69f",
        "#990", "#993", "#996", "#999", "#99c", "#99f", "#c90", "#c93", "#c96", "#c99", "#c9c", "#c9f", "#f90", "#f93", "#f96", "#f99", "#f9c", "#f9f",
        "#0c0", "#0c3", "#0c6", "#0c9", "#0cc", "#0cf", "#3c0", "#3c3", "#3c6", "#3c9", "#3cc", "#3cf", "#6c0", "#6c3", "#6c6", "#6c9", "#6cc", "#6cf",
        "#9c0", "#9c3", "#9c6", "#9c9", "#9cc", "#9cf", "#cc0", "#cc3", "#cc6", "#cc9", "#ccc", "#ccf", "#fc0", "#fc3", "#fc6", "#fc9", "#fcc", "#fcf",
        "#0f0", "#0f3", "#0f6", "#0f9", "#0fc", "#0ff", "#3f0", "#3f3", "#3f6", "#3f9", "#3fc", "#3ff", "#6f0", "#6f3", "#6f6", "#6f9", "#6fc", "#6ff",
        "#9f0", "#9f3", "#9f6", "#9f9", "#9fc", "#9ff", "#cf0", "#cf3", "#cf6", "#cf9", "#cfc", "#cff", "#ff0", "#ff3", "#ff6", "#ff9", "#ffc", "#fff"];
    const total = colors.length;
    const width = 18;
    let cp_contents = "";
    var windowRef = (windowMode) ? "window.opener." : "";
    if (windowMode) {
        cp_contents += "<html lang='en'>";
        cp_contents += "<head>";
        cp_contents += "<title>Select Color</title>";
        cp_contents += "<link href='css/style.css' rel='stylesheet'>";
        cp_contents += "</head>";
        cp_contents += "<body>";
    }
    cp_contents += "<table style='margin: auto;' border='1' cellspacing='1' cellpadding='0'>";
    var use_highlight = (document.getElementById || document.all) ? true : false;
    for (let i = 0; i < total; i++) {
        if ((i % width) === 0) cp_contents += "<tr>";

        if (use_highlight) {
            var mo = 'onMouseOver="' + windowRef + 'ColorPicker_highlightColor(\'' + colors[i] + '\',window.document)"';
        } else {
            mo = "";
        }
        cp_contents += '<td bgcolor="' + colors[i] + '">';
        cp_contents += '<span style="font-size: x-small;"><a href="#" onClick="' + windowRef + 'ColorPicker_pickColor(\'' + colors[i] + '\',' + windowRef + 'window.popupWindowObjects[' + cp.index + ']);return false;" ' + mo + ' style="text-decoration: none;">&nbsp;&nbsp;&nbsp;</a></span>';
        cp_contents += '</td>';
        if (((i + 1) >= total) || (((i + 1) % width) === 0)) {
            cp_contents += "</tr>";
        }
    }
    // If the browser supports dynamically changing TD cells, add the fancy stuff
    if (document.getElementById) {
        const width1 = Math.floor(width / 2);
        const width2 = width1;
        cp_contents += "<tr>";
        cp_contents += "<td colspan='" + width1 + "' style='background-color: #fff;' id='colorPickerSelectedColor'>&nbsp;</td>";
        cp_contents += "<td colspan='" + width2 + "' style='text-align: center;' id='colorPickerSelectedColorValue'>#fff</td>";
        cp_contents += "</tr>";
    }
    cp_contents += "</table>";
    if (windowMode) {
        cp_contents += "</body>";
        cp_contents += "</html>";
    }
    // end populate code

    // Write the contents to the popup object
    cp.populate(cp_contents + "\n");
    // Move the table down a bit so you can see it
    cp.offsetY = 25;
    cp.autoHide();
    return cp;
}
