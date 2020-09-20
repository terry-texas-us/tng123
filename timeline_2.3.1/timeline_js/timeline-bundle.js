﻿/* band.js */
Timeline._Band = function (F, G, B) {
    if (F.autoWidth && typeof G.width == "string") {
        G.width = G.width.indexOf("%") > -1 ? 0 : parseInt(G.width);
    }
    this._timeline = F;
    this._bandInfo = G;
    this._index = B;
    this._locale = ("locale" in G) ? G.locale : Timeline.getDefaultLocale();
    this._timeZone = ("timeZone" in G) ? G.timeZone : 0;
    this._labeller = ("labeller" in G) ? G.labeller : (("createLabeller" in F.getUnit()) ? F.getUnit().createLabeller(this._locale, this._timeZone) : new Timeline.GregorianDateLabeller(this._locale, this._timeZone));
    this._theme = G.theme;
    this._zoomIndex = ("zoomIndex" in G) ? G.zoomIndex : 0;
    this._zoomSteps = ("zoomSteps" in G) ? G.zoomSteps : null;
    this._dragging = false;
    this._changing = false;
    this._originalScrollSpeed = 5;
    this._scrollSpeed = this._originalScrollSpeed;
    this._onScrollListeners = [];
    var A = this;
    this._syncWithBand = null;
    this._syncWithBandHandler = function (H) {
        A._onHighlightBandScroll();
    };
    this._selectorListener = function (H) {
        A._onHighlightBandScroll();
    };
    var D = this._timeline.getDocument().createElement("div");
    D.className = "timeline-band-input";
    this._timeline.addDiv(D);
    this._keyboardInput = document.createElement("input");
    this._keyboardInput.type = "text";
    D.appendChild(this._keyboardInput);
    SimileAjax.DOM.registerEventWithObject(this._keyboardInput, "keydown", this, "_onKeyDown");
    SimileAjax.DOM.registerEventWithObject(this._keyboardInput, "keyup", this, "_onKeyUp");
    this._div = this._timeline.getDocument().createElement("div");
    this._div.id = "timeline-band-" + B;
    this._div.className = "timeline-band timeline-band-" + B;
    this._timeline.addDiv(this._div);
    SimileAjax.DOM.registerEventWithObject(this._div, "mousedown", this, "_onMouseDown");
    SimileAjax.DOM.registerEventWithObject(this._div, "mousemove", this, "_onMouseMove");
    SimileAjax.DOM.registerEventWithObject(this._div, "mouseup", this, "_onMouseUp");
    SimileAjax.DOM.registerEventWithObject(this._div, "mouseout", this, "_onMouseOut");
    SimileAjax.DOM.registerEventWithObject(this._div, "dblclick", this, "_onDblClick");
    var E = this._theme != null ? this._theme.mouseWheel : "scroll";
    if (E === "zoom" || E === "scroll" || this._zoomSteps) {
        if (SimileAjax.Platform.browser.isFirefox) {
            SimileAjax.DOM.registerEventWithObject(this._div, "DOMMouseScroll", this, "_onMouseScroll");
        } else {
            SimileAjax.DOM.registerEventWithObject(this._div, "mousewheel", this, "_onMouseScroll");
        }
    }
    this._innerDiv = this._timeline.getDocument().createElement("div");
    this._innerDiv.className = "timeline-band-inner";
    this._div.appendChild(this._innerDiv);
    this._ether = G.ether;
    G.ether.initialize(this, F);
    this._etherPainter = G.etherPainter;
    G.etherPainter.initialize(this, F);
    this._eventSource = G.eventSource;
    if (this._eventSource) {
        this._eventListener = {
            onAddMany: function () {
                A._onAddMany();
            }, onClear: function () {
                A._onClear();
            }
        };
        this._eventSource.addListener(this._eventListener);
    }
    this._eventPainter = G.eventPainter;
    this._eventTracksNeeded = 0;
    this._eventTrackIncrement = 0;
    G.eventPainter.initialize(this, F);
    this._decorators = ("decorators" in G) ? G.decorators : [];
    for (var C = 0;
         C < this._decorators.length;
         C++) {
        this._decorators[C].initialize(this, F);
    }
};
Timeline._Band.SCROLL_MULTIPLES = 5;
Timeline._Band.prototype.dispose = function () {
    this.closeBubble();
    if (this._eventSource) {
        this._eventSource.removeListener(this._eventListener);
        this._eventListener = null;
        this._eventSource = null;
    }
    this._timeline = null;
    this._bandInfo = null;
    this._labeller = null;
    this._ether = null;
    this._etherPainter = null;
    this._eventPainter = null;
    this._decorators = null;
    this._onScrollListeners = null;
    this._syncWithBandHandler = null;
    this._selectorListener = null;
    this._div = null;
    this._innerDiv = null;
    this._keyboardInput = null;
};
Timeline._Band.prototype.addOnScrollListener = function (A) {
    this._onScrollListeners.push(A);
};
Timeline._Band.prototype.removeOnScrollListener = function (B) {
    for (var A = 0;
         A < this._onScrollListeners.length;
         A++) {
        if (this._onScrollListeners[A] == B) {
            this._onScrollListeners.splice(A, 1);
            break;
        }
    }
};
Timeline._Band.prototype.setSyncWithBand = function (B, A) {
    if (this._syncWithBand) {
        this._syncWithBand.removeOnScrollListener(this._syncWithBandHandler);
    }
    this._syncWithBand = B;
    this._syncWithBand.addOnScrollListener(this._syncWithBandHandler);
    this._highlight = A;
    this._positionHighlight();
};
Timeline._Band.prototype.getLocale = function () {
    return this._locale;
};
Timeline._Band.prototype.getTimeZone = function () {
    return this._timeZone;
};
Timeline._Band.prototype.getLabeller = function () {
    return this._labeller;
};
Timeline._Band.prototype.getIndex = function () {
    return this._index;
};
Timeline._Band.prototype.getEther = function () {
    return this._ether;
};
Timeline._Band.prototype.getEtherPainter = function () {
    return this._etherPainter;
};
Timeline._Band.prototype.getEventSource = function () {
    return this._eventSource;
};
Timeline._Band.prototype.getEventPainter = function () {
    return this._eventPainter;
};
Timeline._Band.prototype.getTimeline = function () {
    return this._timeline;
};
Timeline._Band.prototype.updateEventTrackInfo = function (B, A) {
    this._eventTrackIncrement = A;
    if (B > this._eventTracksNeeded) {
        this._eventTracksNeeded = B;
    }
};
Timeline._Band.prototype.checkAutoWidth = function () {
    if (!this._timeline.autoWidth) {
        return;
    }
    var A = this._eventPainter.getType() == "overview";
    var C = A ? this._theme.event.overviewTrack.autoWidthMargin : this._theme.event.track.autoWidthMargin;
    var B = Math.ceil((this._eventTracksNeeded + C) * this._eventTrackIncrement);
    B += A ? this._theme.event.overviewTrack.offset : this._theme.event.track.offset;
    var D = this._bandInfo;
    if (B != D.width) {
        D.width = B;
    }
};
Timeline._Band.prototype.layout = function () {
    this.paint();
};
Timeline._Band.prototype.paint = function () {
    this._etherPainter.paint();
    this._paintDecorators();
    this._paintEvents();
};
Timeline._Band.prototype.softLayout = function () {
    this.softPaint();
};
Timeline._Band.prototype.softPaint = function () {
    this._etherPainter.softPaint();
    this._softPaintDecorators();
    this._softPaintEvents();
};
Timeline._Band.prototype.setBandShiftAndWidth = function (A, D) {
    var C = this._keyboardInput.parentNode;
    var B = A + Math.floor(D / 2);
    if (this._timeline.isHorizontal()) {
        this._div.style.top = A + "px";
        this._div.style.height = D + "px";
        C.style.top = B + "px";
        C.style.left = "-1em";
    } else {
        this._div.style.left = A + "px";
        this._div.style.width = D + "px";
        C.style.left = B + "px";
        C.style.top = "-1em";
    }
};
Timeline._Band.prototype.getViewWidth = function () {
    if (this._timeline.isHorizontal()) {
        return this._div.offsetHeight;
    } else {
        return this._div.offsetWidth;
    }
};
Timeline._Band.prototype.setViewLength = function (A) {
    this._viewLength = A;
    this._recenterDiv();
    this._onChanging();
};
Timeline._Band.prototype.getViewLength = function () {
    return this._viewLength;
};
Timeline._Band.prototype.getTotalViewLength = function () {
    return Timeline._Band.SCROLL_MULTIPLES * this._viewLength;
};
Timeline._Band.prototype.getViewOffset = function () {
    return this._viewOffset;
};
Timeline._Band.prototype.getMinDate = function () {
    return this._ether.pixelOffsetToDate(this._viewOffset);
};
Timeline._Band.prototype.getMaxDate = function () {
    return this._ether.pixelOffsetToDate(this._viewOffset + Timeline._Band.SCROLL_MULTIPLES * this._viewLength);
};
Timeline._Band.prototype.getMinVisibleDate = function () {
    return this._ether.pixelOffsetToDate(0);
};
Timeline._Band.prototype.getMinVisibleDateAfterDelta = function (A) {
    return this._ether.pixelOffsetToDate(A);
};
Timeline._Band.prototype.getMaxVisibleDate = function () {
    return this._ether.pixelOffsetToDate(this._viewLength);
};
Timeline._Band.prototype.getMaxVisibleDateAfterDelta = function (A) {
    return this._ether.pixelOffsetToDate(this._viewLength + A);
};
Timeline._Band.prototype.getCenterVisibleDate = function () {
    return this._ether.pixelOffsetToDate(this._viewLength / 2);
};
Timeline._Band.prototype.setMinVisibleDate = function (A) {
    if (!this._changing) {
        this._moveEther(Math.round(-this._ether.dateToPixelOffset(A)));
    }
};
Timeline._Band.prototype.setMaxVisibleDate = function (A) {
    if (!this._changing) {
        this._moveEther(Math.round(this._viewLength - this._ether.dateToPixelOffset(A)));
    }
};
Timeline._Band.prototype.setCenterVisibleDate = function (A) {
    if (!this._changing) {
        this._moveEther(Math.round(this._viewLength / 2 - this._ether.dateToPixelOffset(A)));
    }
};
Timeline._Band.prototype.dateToPixelOffset = function (A) {
    return this._ether.dateToPixelOffset(A) - this._viewOffset;
};
Timeline._Band.prototype.pixelOffsetToDate = function (A) {
    return this._ether.pixelOffsetToDate(A + this._viewOffset);
};
Timeline._Band.prototype.createLayerDiv = function (D, B) {
    var C = this._timeline.getDocument().createElement("div");
    C.className = "timeline-band-layer" + (typeof B == "string" ? (" " + B) : "");
    C.style.zIndex = D;
    this._innerDiv.appendChild(C);
    var A = this._timeline.getDocument().createElement("div");
    A.className = "timeline-band-layer-inner";
    if (SimileAjax.Platform.browser.isIE) {
        A.style.cursor = "move";
    } else {
        A.style.cursor = "-moz-grab";
    }
    C.appendChild(A);
    return A;
};
Timeline._Band.prototype.removeLayerDiv = function (A) {
    this._innerDiv.removeChild(A.parentNode);
};
Timeline._Band.prototype.scrollToCenter = function (B, C) {
    var A = this._ether.dateToPixelOffset(B);
    if (A < -this._viewLength / 2) {
        this.setCenterVisibleDate(this.pixelOffsetToDate(A + this._viewLength));
    } else {
        if (A > 3 * this._viewLength / 2) {
            this.setCenterVisibleDate(this.pixelOffsetToDate(A - this._viewLength));
        }
    }
    this._autoScroll(Math.round(this._viewLength / 2 - this._ether.dateToPixelOffset(B)), C);
};
Timeline._Band.prototype.showBubbleForEvent = function (C) {
    var A = this.getEventSource().getEvent(C);
    if (A) {
        var B = this;
        this.scrollToCenter(A.getStart(), function () {
            B._eventPainter.showBubble(A);
        });
    }
};
Timeline._Band.prototype.zoom = function (F, A, E, C) {
    if (!this._zoomSteps) {
        return;
    }
    A += this._viewOffset;
    var D = this._ether.pixelOffsetToDate(A);
    var B = this._ether.zoom(F);
    this._etherPainter.zoom(B);
    this._moveEther(Math.round(-this._ether.dateToPixelOffset(D)));
    this._moveEther(A);
};
Timeline._Band.prototype._onMouseDown = function (B, A, C) {
    this.closeBubble();
    this._dragging = true;
    this._dragX = A.clientX;
    this._dragY = A.clientY;
};
Timeline._Band.prototype._onMouseMove = function (D, A, E) {
    if (this._dragging) {
        var C = A.clientX - this._dragX;
        var B = A.clientY - this._dragY;
        this._dragX = A.clientX;
        this._dragY = A.clientY;
        this._moveEther(this._timeline.isHorizontal() ? C : B);
        this._positionHighlight();
    }
};
Timeline._Band.prototype._onMouseUp = function (B, A, C) {
    this._dragging = false;
    this._keyboardInput.focus();
};
Timeline._Band.prototype._onMouseOut = function (B, A, D) {
    var C = SimileAjax.DOM.getEventRelativeCoordinates(A, B);
    C.x += this._viewOffset;
    if (C.x < 0 || C.x > B.offsetWidth || C.y < 0 || C.y > B.offsetHeight) {
        this._dragging = false;
    }
};
Timeline._Band.prototype._onMouseScroll = function (G, I, E) {
    var A = new Date();
    A = A.getTime();
    if (!this._lastScrollTime || ((A - this._lastScrollTime) > 50)) {
        this._lastScrollTime = A;
        var H = 0;
        if (I.wheelDelta) {
            H = I.wheelDelta / 120;
        } else {
            if (I.detail) {
                H = -I.detail / 3;
            }
        }
        var F = this._theme.mouseWheel;
        if (this._zoomSteps || F === "zoom") {
            var D = SimileAjax.DOM.getEventRelativeCoordinates(I, G);
            if (H != 0) {
                var C;
                if (H > 0) {
                    C = true;
                }
                if (H < 0) {
                    C = false;
                }
                this._timeline.zoom(C, D.x, D.y, G);
            }
        } else {
            if (F === "scroll") {
                var B = 50 * (H < 0 ? -1 : 1);
                this._moveEther(B);
            }
        }
    }
    if (I.stopPropagation) {
        I.stopPropagation();
    }
    I.cancelBubble = true;
    if (I.preventDefault) {
        I.preventDefault();
    }
    I.returnValue = false;
};
Timeline._Band.prototype._onDblClick = function (B, A, D) {
    var C = SimileAjax.DOM.getEventRelativeCoordinates(A, B);
    var E = C.x - (this._viewLength / 2 - this._viewOffset);
    this._autoScroll(-E);
};
Timeline._Band.prototype._onKeyDown = function (B, A, C) {
    if (!this._dragging) {
        switch (A.keyCode) {
            case 27:
                break;
            case 37:
            case 38:
                this._scrollSpeed = Math.min(50, Math.abs(this._scrollSpeed * 1.05));
                this._moveEther(this._scrollSpeed);
                break;
            case 39:
            case 40:
                this._scrollSpeed = -Math.min(50, Math.abs(this._scrollSpeed * 1.05));
                this._moveEther(this._scrollSpeed);
                break;
            default:
                return true;
        }
        this.closeBubble();
        SimileAjax.DOM.cancelEvent(A);
        return false;
    }
    return true;
};
Timeline._Band.prototype._onKeyUp = function (B, A, C) {
    if (!this._dragging) {
        this._scrollSpeed = this._originalScrollSpeed;
        switch (A.keyCode) {
            case 35:
                this.setCenterVisibleDate(this._eventSource.getLatestDate());
                break;
            case 36:
                this.setCenterVisibleDate(this._eventSource.getEarliestDate());
                break;
            case 33:
                this._autoScroll(this._timeline.getPixelLength());
                break;
            case 34:
                this._autoScroll(-this._timeline.getPixelLength());
                break;
            default:
                return true;
        }
        this.closeBubble();
        SimileAjax.DOM.cancelEvent(A);
        return false;
    }
    return true;
};
Timeline._Band.prototype._autoScroll = function (D, C) {
    var A = this;
    var B = SimileAjax.Graphics.createAnimation(function (E, F) {
        A._moveEther(F);
    }, 0, D, 1000, C);
    B.run();
};
Timeline._Band.prototype._moveEther = function (A) {
    this.closeBubble();
    if (!this._timeline.shiftOK(this._index, A)) {
        return;
    }
    this._viewOffset += A;
    this._ether.shiftPixels(-A);
    if (this._timeline.isHorizontal()) {
        this._div.style.left = this._viewOffset + "px";
    } else {
        this._div.style.top = this._viewOffset + "px";
    }
    if (this._viewOffset > -this._viewLength * 0.5 || this._viewOffset < -this._viewLength * (Timeline._Band.SCROLL_MULTIPLES - 1.5)) {
        this._recenterDiv();
    } else {
        this.softLayout();
    }
    this._onChanging();
};
Timeline._Band.prototype._onChanging = function () {
    this._changing = true;
    this._fireOnScroll();
    this._setSyncWithBandDate();
    this._changing = false;
};
Timeline._Band.prototype.busy = function () {
    return (this._changing);
};
Timeline._Band.prototype._fireOnScroll = function () {
    for (var A = 0;
         A < this._onScrollListeners.length;
         A++) {
        this._onScrollListeners[A](this);
    }
};
Timeline._Band.prototype._setSyncWithBandDate = function () {
    if (this._syncWithBand) {
        var A = this._ether.pixelOffsetToDate(this.getViewLength() / 2);
        this._syncWithBand.setCenterVisibleDate(A);
    }
};
Timeline._Band.prototype._onHighlightBandScroll = function () {
    if (this._syncWithBand) {
        var A = this._syncWithBand.getCenterVisibleDate();
        var B = this._ether.dateToPixelOffset(A);
        this._moveEther(Math.round(this._viewLength / 2 - B));
        if (this._highlight) {
            this._etherPainter.setHighlight(this._syncWithBand.getMinVisibleDate(), this._syncWithBand.getMaxVisibleDate());
        }
    }
};
Timeline._Band.prototype._onAddMany = function () {
    this._paintEvents();
};
Timeline._Band.prototype._onClear = function () {
    this._paintEvents();
};
Timeline._Band.prototype._positionHighlight = function () {
    if (this._syncWithBand) {
        var A = this._syncWithBand.getMinVisibleDate();
        var B = this._syncWithBand.getMaxVisibleDate();
        if (this._highlight) {
            this._etherPainter.setHighlight(A, B);
        }
    }
};
Timeline._Band.prototype._recenterDiv = function () {
    this._viewOffset = -this._viewLength * (Timeline._Band.SCROLL_MULTIPLES - 1) / 2;
    if (this._timeline.isHorizontal()) {
        this._div.style.left = this._viewOffset + "px";
        this._div.style.width = (Timeline._Band.SCROLL_MULTIPLES * this._viewLength) + "px";
    } else {
        this._div.style.top = this._viewOffset + "px";
        this._div.style.height = (Timeline._Band.SCROLL_MULTIPLES * this._viewLength) + "px";
    }
    this.layout();
};
Timeline._Band.prototype._paintEvents = function () {
    this._eventPainter.paint();
};
Timeline._Band.prototype._softPaintEvents = function () {
    this._eventPainter.softPaint();
};
Timeline._Band.prototype._paintDecorators = function () {
    for (var A = 0;
         A < this._decorators.length;
         A++) {
        this._decorators[A].paint();
    }
};
Timeline._Band.prototype._softPaintDecorators = function () {
    for (var A = 0;
         A < this._decorators.length;
         A++) {
        this._decorators[A].softPaint();
    }
};
Timeline._Band.prototype.closeBubble = function () {
    SimileAjax.WindowManager.cancelPopups();
};


/* compact-painter.js */
Timeline.CompactEventPainter = function (A) {
    this._params = A;
    this._onSelectListeners = [];
    this._filterMatcher = null;
    this._highlightMatcher = null;
    this._frc = null;
    this._eventIdToElmt = {};
};
Timeline.CompactEventPainter.prototype.initialize = function (B, A) {
    this._band = B;
    this._timeline = A;
    this._backLayer = null;
    this._eventLayer = null;
    this._lineLayer = null;
    this._highlightLayer = null;
    this._eventIdToElmt = null;
};
Timeline.CompactEventPainter.prototype.addOnSelectListener = function (A) {
    this._onSelectListeners.push(A);
};
Timeline.CompactEventPainter.prototype.removeOnSelectListener = function (B) {
    for (var A = 0;
         A < this._onSelectListeners.length;
         A++) {
        if (this._onSelectListeners[A] == B) {
            this._onSelectListeners.splice(A, 1);
            break;
        }
    }
};
Timeline.CompactEventPainter.prototype.getFilterMatcher = function () {
    return this._filterMatcher;
};
Timeline.CompactEventPainter.prototype.setFilterMatcher = function (A) {
    this._filterMatcher = A;
};
Timeline.CompactEventPainter.prototype.getHighlightMatcher = function () {
    return this._highlightMatcher;
};
Timeline.CompactEventPainter.prototype.setHighlightMatcher = function (A) {
    this._highlightMatcher = A;
};
Timeline.CompactEventPainter.prototype.paint = function () {
    var P = this._band.getEventSource();
    if (P == null) {
        return;
    }
    this._eventIdToElmt = {};
    this._prepareForPainting();
    var Q = this._params.theme;
    var N = Q.event;
    var I = {
        trackOffset: "trackOffset" in this._params ? this._params.trackOffset : 10,
        trackHeight: "trackHeight" in this._params ? this._params.trackHeight : 10,
        tapeHeight: Q.event.tape.height,
        tapeBottomMargin: "tapeBottomMargin" in this._params ? this._params.tapeBottomMargin : 2,
        labelBottomMargin: "labelBottomMargin" in this._params ? this._params.labelBottomMargin : 5,
        labelRightMargin: "labelRightMargin" in this._params ? this._params.labelRightMargin : 5,
        defaultIcon: N.instant.icon,
        defaultIconWidth: N.instant.iconWidth,
        defaultIconHeight: N.instant.iconHeight,
        customIconWidth: "iconWidth" in this._params ? this._params.iconWidth : N.instant.iconWidth,
        customIconHeight: "iconHeight" in this._params ? this._params.iconHeight : N.instant.iconHeight,
        iconLabelGap: "iconLabelGap" in this._params ? this._params.iconLabelGap : 2,
        iconBottomMargin: "iconBottomMargin" in this._params ? this._params.iconBottomMargin : 2
    };
    if ("compositeIcon" in this._params) {
        I.compositeIcon = this._params.compositeIcon;
        I.compositeIconWidth = this._params.compositeIconWidth || I.customIconWidth;
        I.compositeIconHeight = this._params.compositeIconHeight || I.customIconHeight;
    } else {
        I.compositeIcon = I.defaultIcon;
        I.compositeIconWidth = I.defaultIconWidth;
        I.compositeIconHeight = I.defaultIconHeight;
    }
    I.defaultStackIcon = "icon" in this._params.stackConcurrentPreciseInstantEvents ? this._params.stackConcurrentPreciseInstantEvents.icon : I.defaultIcon;
    I.defaultStackIconWidth = "iconWidth" in this._params.stackConcurrentPreciseInstantEvents ? this._params.stackConcurrentPreciseInstantEvents.iconWidth : I.defaultIconWidth;
    I.defaultStackIconHeight = "iconHeight" in this._params.stackConcurrentPreciseInstantEvents ? this._params.stackConcurrentPreciseInstantEvents.iconHeight : I.defaultIconHeight;
    var B = this._band.getMinDate();
    var D = this._band.getMaxDate();
    var R = (this._filterMatcher != null) ? this._filterMatcher : function (S) {
        return true;
    };
    var F = (this._highlightMatcher != null) ? this._highlightMatcher : function (S) {
        return -1;
    };
    var H = P.getEventIterator(B, D);
    var J = "stackConcurrentPreciseInstantEvents" in this._params && typeof this._params.stackConcurrentPreciseInstantEvents == "object";
    var G = "collapseConcurrentPreciseInstantEvents" in this._params && this._params.collapseConcurrentPreciseInstantEvents;
    if (G || J) {
        var M = [];
        var A = null;
        while (H.hasNext()) {
            var E = H.next();
            if (R(E)) {
                if (!E.isInstant() || E.isImprecise()) {
                    this.paintEvent(E, I, this._params.theme, F(E));
                } else {
                    if (A != null && A.getStart().getTime() == E.getStart().getTime()) {
                        M[M.length - 1].push(E);
                    } else {
                        M.push([E]);
                        A = E;
                    }
                }
            }
        }
        for (var L = 0;
             L < M.length;
             L++) {
            var O = M[L];
            if (O.length == 1) {
                this.paintEvent(O[0], I, this._params.theme, F(E));
            } else {
                var C = -1;
                for (var K = 0;
                     C < 0 && K < O.length;
                     K++) {
                    C = F(O[K]);
                }
                if (J) {
                    this.paintStackedPreciseInstantEvents(O, I, this._params.theme, C);
                } else {
                    this.paintCompositePreciseInstantEvents(O, I, this._params.theme, C);
                }
            }
        }
    } else {
        while (H.hasNext()) {
            var E = H.next();
            if (R(E)) {
                this.paintEvent(E, I, this._params.theme, F(E));
            }
        }
    }
    this._highlightLayer.style.display = "block";
    this._lineLayer.style.display = "block";
    this._eventLayer.style.display = "block";
};
Timeline.CompactEventPainter.prototype.softPaint = function () {
};
Timeline.CompactEventPainter.prototype._prepareForPainting = function () {
    var B = this._band;
    if (this._backLayer == null) {
        this._backLayer = this._band.createLayerDiv(0, "timeline-band-events");
        this._backLayer.style.visibility = "hidden";
        var A = document.createElement("span");
        A.className = "timeline-event-label";
        this._backLayer.appendChild(A);
        this._frc = SimileAjax.Graphics.getFontRenderingContext(A);
    }
    this._frc.update();
    this._tracks = [];
    if (this._highlightLayer != null) {
        B.removeLayerDiv(this._highlightLayer);
    }
    this._highlightLayer = B.createLayerDiv(105, "timeline-band-highlights");
    this._highlightLayer.style.display = "none";
    if (this._lineLayer != null) {
        B.removeLayerDiv(this._lineLayer);
    }
    this._lineLayer = B.createLayerDiv(110, "timeline-band-lines");
    this._lineLayer.style.display = "none";
    if (this._eventLayer != null) {
        B.removeLayerDiv(this._eventLayer);
    }
    this._eventLayer = B.createLayerDiv(115, "timeline-band-events");
    this._eventLayer.style.display = "none";
};
Timeline.CompactEventPainter.prototype.paintEvent = function (B, C, D, A) {
    if (B.isInstant()) {
        this.paintInstantEvent(B, C, D, A);
    } else {
        this.paintDurationEvent(B, C, D, A);
    }
};
Timeline.CompactEventPainter.prototype.paintInstantEvent = function (B, C, D, A) {
    if (B.isImprecise()) {
        this.paintImpreciseInstantEvent(B, C, D, A);
    } else {
        this.paintPreciseInstantEvent(B, C, D, A);
    }
};
Timeline.CompactEventPainter.prototype.paintDurationEvent = function (B, C, D, A) {
    if (B.isImprecise()) {
        this.paintImpreciseDurationEvent(B, C, D, A);
    } else {
        this.paintPreciseDurationEvent(B, C, D, A);
    }
};
Timeline.CompactEventPainter.prototype.paintPreciseInstantEvent = function (H, F, C, B) {
    var D = {tooltip: H.getProperty("tooltip") || H.getText()};
    var A = {url: H.getIcon()};
    if (A.url == null) {
        A.url = F.defaultIcon;
        A.width = F.defaultIconWidth;
        A.height = F.defaultIconHeight;
        A.className = "timeline-event-icon-default";
    } else {
        A.width = H.getProperty("iconWidth") || F.customIconWidth;
        A.height = H.getProperty("iconHeight") || F.customIconHeight;
    }
    var G = {text: H.getText(), color: H.getTextColor() || H.getColor(), className: H.getClassName()};
    var J = this.paintTapeIconLabel(H.getStart(), D, null, A, G, F, C, B);
    var I = this;
    var E = function (K, L, M) {
        return I._onClickInstantEvent(J.iconElmtData.elmt, L, H);
    };
    SimileAjax.DOM.registerEvent(J.iconElmtData.elmt, "mousedown", E);
    SimileAjax.DOM.registerEvent(J.labelElmtData.elmt, "mousedown", E);
    this._eventIdToElmt[H.getID()] = J.iconElmtData.elmt;
};
Timeline.CompactEventPainter.prototype.paintCompositePreciseInstantEvents = function (L, H, C, B) {
    var J = L[0];
    var G = [];
    for (var D = 0;
         D < L.length;
         D++) {
        G.push(L[D].getProperty("tooltip") || L[D].getText());
    }
    var E = {tooltip: G.join("; ")};
    var A = {url: H.compositeIcon, width: H.compositeIconWidth, height: H.compositeIconHeight, className: "timeline-event-icon-composite"};
    var I = {text: String.substitute(this._params.compositeEventLabelTemplate, [L.length])};
    var M = this.paintTapeIconLabel(J.getStart(), E, null, A, I, H, C, B);
    var K = this;
    var F = function (N, O, P) {
        return K._onClickMultiplePreciseInstantEvent(M.iconElmtData.elmt, O, L);
    };
    SimileAjax.DOM.registerEvent(M.iconElmtData.elmt, "mousedown", F);
    SimileAjax.DOM.registerEvent(M.labelElmtData.elmt, "mousedown", F);
    for (var D = 0;
         D < L.length;
         D++) {
        this._eventIdToElmt[L[D].getID()] = M.iconElmtData.elmt;
    }
};
Timeline.CompactEventPainter.prototype.paintStackedPreciseInstantEvents = function (X, k, b, E) {
    var S = "limit" in this._params.stackConcurrentPreciseInstantEvents ? this._params.stackConcurrentPreciseInstantEvents.limit : 10;
    var I = "moreMessageTemplate" in this._params.stackConcurrentPreciseInstantEvents ? this._params.stackConcurrentPreciseInstantEvents.moreMessageTemplate : "%0 More Events";
    var P = S <= X.length - 2;
    var C = this._band;
    var e = function (i) {
        return Math.round(C.dateToPixelOffset(i));
    };
    var N = function (i) {
        var r = {url: i.getIcon()};
        if (r.url == null) {
            r.url = k.defaultStackIcon;
            r.width = k.defaultStackIconWidth;
            r.height = k.defaultStackIconHeight;
            r.className = "timeline-event-icon-stack timeline-event-icon-default";
        } else {
            r.width = i.getProperty("iconWidth") || k.customIconWidth;
            r.height = i.getProperty("iconHeight") || k.customIconHeight;
            r.className = "timeline-event-icon-stack";
        }
        return r;
    };
    var G = N(X[0]);
    var V = 5;
    var F = 0;
    var K = 0;
    var q = 0;
    var W = 0;
    var m = [];
    for (var p = 0;
         p < X.length && (!P || p < S);
         p++) {
        var a = X[p];
        var Z = a.getText();
        var U = N(a);
        var T = this._frc.computeSize(Z);
        var g = {text: Z, iconData: U, labelSize: T, iconLeft: G.width + p * V - U.width};
        g.labelLeft = G.width + p * V + k.iconLabelGap;
        g.top = q;
        m.push(g);
        F = Math.min(F, g.iconLeft);
        q += T.height;
        K = Math.max(K, g.labelLeft + T.width);
        W = Math.max(W, g.top + U.height);
    }
    if (P) {
        var L = String.substitute(I, [X.length - S]);
        var l = this._frc.computeSize(L);
        var h = G.width + (S - 1) * V + k.iconLabelGap;
        var o = q;
        q += l.height;
        K = Math.max(K, h + l.width);
    }
    K += k.labelRightMargin;
    q += k.labelBottomMargin;
    W += k.iconBottomMargin;
    var n = e(X[0].getStart());
    var R = [];
    var M = Math.ceil(Math.max(W, q) / k.trackHeight);
    var d = G.width + (X.length - 1) * V;
    for (var p = 0;
         p < M;
         p++) {
        R.push({start: F, end: d});
    }
    var f = Math.ceil(q / k.trackHeight);
    for (var p = 0;
         p < f;
         p++) {
        var O = R[p];
        O.end = Math.max(O.end, K);
    }
    var H = this._fitTracks(n, R);
    var Y = H * k.trackHeight + k.trackOffset;
    var A = this._timeline.getDocument().createElement("div");
    A.className = "timeline-event-icon-stack";
    A.style.position = "absolute";
    A.style.overflow = "visible";
    A.style.left = n + "px";
    A.style.top = Y + "px";
    A.style.width = d + "px";
    A.style.height = W + "px";
    A.innerHTML = "<div style='position: relative;'></div>";
    this._eventLayer.appendChild(A);
    var J = this;
    var Q = function (s) {
        try {
            var w = parseInt(this.getAttribute("index"));
            var u = A.firstChild.childNodes;
            for (var r = 0;
                 r < u.length;
                 r++) {
                var v = u[r];
                if (r == w) {
                    v.style.zIndex = u.length;
                } else {
                    v.style.zIndex = u.length - r;
                }
            }
        } catch (t) {
        }
    };
    var c = function (v) {
        var r = m[v];
        var i = X[v];
        var w = i.getProperty("tooltip") || i.getText();
        var u = J._paintEventLabel({tooltip: w}, {text: r.text}, n + r.labelLeft, Y + r.top, r.labelSize.width, r.labelSize.height, b);
        u.elmt.setAttribute("index", v);
        u.elmt.onmouseover = Q;
        var t = SimileAjax.Graphics.createTranslucentImage(r.iconData.url);
        var s = J._timeline.getDocument().createElement("div");
        s.className = "timeline-event-icon" + ("className" in r.iconData ? (" " + r.iconData.className) : "");
        s.style.left = r.iconLeft + "px";
        s.style.top = r.top + "px";
        s.style.zIndex = (m.length - v);
        s.appendChild(t);
        s.setAttribute("index", v);
        s.onmouseover = Q;
        A.firstChild.appendChild(s);
        var x = function (y, z, AA) {
            return J._onClickInstantEvent(u.elmt, z, i);
        };
        SimileAjax.DOM.registerEvent(s, "mousedown", x);
        SimileAjax.DOM.registerEvent(u.elmt, "mousedown", x);
        J._eventIdToElmt[i.getID()] = s;
    };
    for (var p = 0;
         p < m.length;
         p++) {
        c(p);
    }
    if (P) {
        var D = X.slice(S);
        var B = this._paintEventLabel({tooltip: L}, {text: L}, n + h, Y + o, l.width, l.height, b);
        var j = function (i, r, s) {
            return J._onClickMultiplePreciseInstantEvent(B.elmt, r, D);
        };
        SimileAjax.DOM.registerEvent(B.elmt, "mousedown", j);
        for (var p = 0;
             p < D.length;
             p++) {
            this._eventIdToElmt[D[p].getID()] = B.elmt;
        }
    }
};
Timeline.CompactEventPainter.prototype.paintImpreciseInstantEvent = function (I, G, D, C) {
    var E = {tooltip: I.getProperty("tooltip") || I.getText()};
    var A = {start: I.getStart(), end: I.getEnd(), latestStart: I.getLatestStart(), earliestEnd: I.getEarliestEnd(), isInstant: true};
    var B = {url: I.getIcon()};
    if (B.url == null) {
        B = null;
    } else {
        B.width = I.getProperty("iconWidth") || G.customIconWidth;
        B.height = I.getProperty("iconHeight") || G.customIconHeight;
    }
    var H = {text: I.getText(), color: I.getTextColor() || I.getColor(), className: I.getClassName()};
    var K = this.paintTapeIconLabel(I.getStart(), E, A, B, H, G, D, C);
    var J = this;
    var F = B != null ? function (L, M, N) {
        return J._onClickInstantEvent(K.iconElmtData.elmt, M, I);
    } : function (L, M, N) {
        return J._onClickInstantEvent(K.labelElmtData.elmt, M, I);
    };
    SimileAjax.DOM.registerEvent(K.labelElmtData.elmt, "mousedown", F);
    SimileAjax.DOM.registerEvent(K.impreciseTapeElmtData.elmt, "mousedown", F);
    if (B != null) {
        SimileAjax.DOM.registerEvent(K.iconElmtData.elmt, "mousedown", F);
        this._eventIdToElmt[I.getID()] = K.iconElmtData.elmt;
    } else {
        this._eventIdToElmt[I.getID()] = K.labelElmtData.elmt;
    }
};
Timeline.CompactEventPainter.prototype.paintPreciseDurationEvent = function (I, G, D, C) {
    var E = {tooltip: I.getProperty("tooltip") || I.getText()};
    var A = {start: I.getStart(), end: I.getEnd(), isInstant: false};
    var B = {url: I.getIcon()};
    if (B.url == null) {
        B = null;
    } else {
        B.width = I.getProperty("iconWidth") || G.customIconWidth;
        B.height = I.getProperty("iconHeight") || G.customIconHeight;
    }
    var H = {text: I.getText(), color: I.getTextColor() || I.getColor(), className: I.getClassName()};
    var K = this.paintTapeIconLabel(I.getLatestStart(), E, A, B, H, G, D, C);
    var J = this;
    var F = B != null ? function (L, M, N) {
        return J._onClickInstantEvent(K.iconElmtData.elmt, M, I);
    } : function (L, M, N) {
        return J._onClickInstantEvent(K.labelElmtData.elmt, M, I);
    };
    SimileAjax.DOM.registerEvent(K.labelElmtData.elmt, "mousedown", F);
    SimileAjax.DOM.registerEvent(K.tapeElmtData.elmt, "mousedown", F);
    if (B != null) {
        SimileAjax.DOM.registerEvent(K.iconElmtData.elmt, "mousedown", F);
        this._eventIdToElmt[I.getID()] = K.iconElmtData.elmt;
    } else {
        this._eventIdToElmt[I.getID()] = K.labelElmtData.elmt;
    }
};
Timeline.CompactEventPainter.prototype.paintImpreciseDurationEvent = function (I, G, D, C) {
    var E = {tooltip: I.getProperty("tooltip") || I.getText()};
    var A = {start: I.getStart(), end: I.getEnd(), latestStart: I.getLatestStart(), earliestEnd: I.getEarliestEnd(), isInstant: false};
    var B = {url: I.getIcon()};
    if (B.url == null) {
        B = null;
    } else {
        B.width = I.getProperty("iconWidth") || G.customIconWidth;
        B.height = I.getProperty("iconHeight") || G.customIconHeight;
    }
    var H = {text: I.getText(), color: I.getTextColor() || I.getColor(), className: I.getClassName()};
    var K = this.paintTapeIconLabel(I.getLatestStart(), E, A, B, H, G, D, C);
    var J = this;
    var F = B != null ? function (L, M, N) {
        return J._onClickInstantEvent(K.iconElmtData.elmt, M, I);
    } : function (L, M, N) {
        return J._onClickInstantEvent(K.labelElmtData.elmt, M, I);
    };
    SimileAjax.DOM.registerEvent(K.labelElmtData.elmt, "mousedown", F);
    SimileAjax.DOM.registerEvent(K.tapeElmtData.elmt, "mousedown", F);
    if (B != null) {
        SimileAjax.DOM.registerEvent(K.iconElmtData.elmt, "mousedown", F);
        this._eventIdToElmt[I.getID()] = K.iconElmtData.elmt;
    } else {
        this._eventIdToElmt[I.getID()] = K.labelElmtData.elmt;
    }
};
Timeline.CompactEventPainter.prototype.paintTapeIconLabel = function (a, M, d, E, X, V, c, Y) {
    var R = this._band;
    var K = function (e) {
        return Math.round(R.dateToPixelOffset(e));
    };
    var S = K(a);
    var b = [];
    var Z = 0;
    var O = 0;
    var N = 0;
    if (d != null) {
        Z = V.tapeHeight + V.tapeBottomMargin;
        O = Math.ceil(V.tapeHeight / V.trackHeight);
        var A = K(d.end) - S;
        var D = K(d.start) - S;
        for (var Q = 0;
             Q < O;
             Q++) {
            b.push({start: D, end: A});
        }
        N = V.trackHeight - (Z % V.tapeHeight);
    }
    var B = 0;
    var U = 0;
    if (E != null) {
        if ("iconAlign" in E && E.iconAlign == "center") {
            B = -Math.floor(E.width / 2);
        }
        U = B + E.width + V.iconLabelGap;
        if (O > 0) {
            b[O - 1].end = Math.max(b[O - 1].end, U);
        }
        var J = E.height + V.iconBottomMargin + N;
        while (J > 0) {
            b.push({start: B, end: U});
            J -= V.trackHeight;
        }
    }
    var P = X.text;
    var G = this._frc.computeSize(P);
    var C = G.height + V.labelBottomMargin + N;
    var F = U + G.width + V.labelRightMargin;
    if (O > 0) {
        b[O - 1].end = Math.max(b[O - 1].end, F);
    }
    for (var W = 0;
         C > 0;
         W++) {
        if (O + W < b.length) {
            var T = b[O + W];
            T.end = F;
        } else {
            b.push({start: 0, end: F});
        }
        C -= V.trackHeight;
    }
    var I = this._fitTracks(S, b);
    var H = I * V.trackHeight + V.trackOffset;
    var L = {};
    L.labelElmtData = this._paintEventLabel(M, X, S + U, H + Z, G.width, G.height, c);
    if (d != null) {
        if ("latestStart" in d || "earliestEnd" in d) {
            L.impreciseTapeElmtData = this._paintEventTape(M, d, V.tapeHeight, H, K(d.start), K(d.end), c.event.duration.impreciseColor, c.event.duration.impreciseOpacity, V, c);
        }
        if (!d.isInstant && "start" in d && "end" in d) {
            L.tapeElmtData = this._paintEventTape(M, d, V.tapeHeight, H, S, K("earliestEnd" in d ? d.earliestEnd : d.end), d.color, 100, V, c);
        }
    }
    if (E != null) {
        L.iconElmtData = this._paintEventIcon(M, E, H + Z, S + B, V, c);
    }
    return L;
};
Timeline.CompactEventPainter.prototype._fitTracks = function (A, F) {
    var H;
    for (H = 0;
         H < this._tracks.length;
         H++) {
        var E = true;
        for (var C = 0;
             C < F.length && (H + C) < this._tracks.length;
             C++) {
            var G = this._tracks[H + C];
            var B = F[C];
            if (A + B.start < G) {
                E = false;
                break;
            }
        }
        if (E) {
            break;
        }
    }
    for (var D = 0;
         D < F.length;
         D++) {
        this._tracks[H + D] = A + F[D].end;
    }
    return H;
};
Timeline.CompactEventPainter.prototype._paintEventIcon = function (C, D, H, G, E, F) {
    var B = SimileAjax.Graphics.createTranslucentImage(D.url);
    var A = this._timeline.getDocument().createElement("div");
    A.className = "timeline-event-icon" + ("className" in D ? (" " + D.className) : "");
    A.style.left = G + "px";
    A.style.top = H + "px";
    A.appendChild(B);
    if ("tooltip" in C && typeof C.tooltip == "string") {
        A.title = C.tooltip;
    }
    this._eventLayer.appendChild(A);
    return {left: G, top: H, width: E.iconWidth, height: E.iconHeight, elmt: A};
};
Timeline.CompactEventPainter.prototype._paintEventLabel = function (D, G, B, F, A, I, C) {
    var H = this._timeline.getDocument();
    var E = H.createElement("div");
    E.className = "timeline-event-label";
    E.style.left = B + "px";
    E.style.width = (A + 1) + "px";
    E.style.top = F + "px";
    E.innerHTML = G.text;
    if ("tooltip" in D && typeof D.tooltip == "string") {
        E.title = D.tooltip;
    }
    if ("color" in G && typeof G.color == "string") {
        E.style.color = G.color;
    }
    if ("className" in G && typeof G.className == "string") {
        E.className += " " + G.className;
    }
    this._eventLayer.appendChild(E);
    return {left: B, top: F, width: A, height: I, elmt: E};
};
Timeline.CompactEventPainter.prototype._paintEventTape = function (G, B, L, J, F, A, D, H, I, E) {
    var C = A - F;
    var K = this._timeline.getDocument().createElement("div");
    K.className = "timeline-event-tape";
    K.style.left = F + "px";
    K.style.top = J + "px";
    K.style.width = C + "px";
    K.style.height = L + "px";
    if ("tooltip" in G && typeof G.tooltip == "string") {
        K.title = G.tooltip;
    }
    if (D != null && typeof B.color == "string") {
        K.style.backgroundColor = D;
    }
    if ("backgroundImage" in B && typeof B.backgroundImage == "string") {
        K.style.backgroundImage = "url(" + backgroundImage + ")";
        K.style.backgroundRepeat = ("backgroundRepeat" in B && typeof B.backgroundRepeat == "string") ? B.backgroundRepeat : "repeat";
    }
    SimileAjax.Graphics.setOpacity(K, H);
    if ("className" in B && typeof B.className == "string") {
        K.className += " " + B.className;
    }
    this._eventLayer.appendChild(K);
    return {left: F, top: J, width: C, height: L, elmt: K};
};
Timeline.CompactEventPainter.prototype._createHighlightDiv = function (A, C, E) {
    if (A >= 0) {
        var D = this._timeline.getDocument();
        var G = E.event;
        var B = G.highlightColors[Math.min(A, G.highlightColors.length - 1)];
        var F = D.createElement("div");
        F.style.position = "absolute";
        F.style.overflow = "hidden";
        F.style.left = (C.left - 2) + "px";
        F.style.width = (C.width + 4) + "px";
        F.style.top = (C.top - 2) + "px";
        F.style.height = (C.height + 4) + "px";
        this._highlightLayer.appendChild(F);
    }
};
Timeline.CompactEventPainter.prototype._onClickMultiplePreciseInstantEvent = function (D, E, B) {
    var F = SimileAjax.DOM.getPageCoordinates(D);
    this._showBubble(F.left + Math.ceil(D.offsetWidth / 2), F.top + Math.ceil(D.offsetHeight / 2), B);
    var C = [];
    for (var A = 0;
         A < B.length;
         A++) {
        C.push(B[A].getID());
    }
    this._fireOnSelect(C);
    E.cancelBubble = true;
    SimileAjax.DOM.cancelEvent(E);
    return false;
};
Timeline.CompactEventPainter.prototype._onClickInstantEvent = function (B, C, A) {
    var D = SimileAjax.DOM.getPageCoordinates(B);
    this._showBubble(D.left + Math.ceil(B.offsetWidth / 2), D.top + Math.ceil(B.offsetHeight / 2), [A]);
    this._fireOnSelect([A.getID()]);
    C.cancelBubble = true;
    SimileAjax.DOM.cancelEvent(C);
    return false;
};
Timeline.CompactEventPainter.prototype._onClickDurationEvent = function (D, C, B) {
    if ("pageX" in C) {
        var A = C.pageX;
        var F = C.pageY;
    } else {
        var E = SimileAjax.DOM.getPageCoordinates(D);
        var A = C.offsetX + E.left;
        var F = C.offsetY + E.top;
    }
    this._showBubble(A, F, [B]);
    this._fireOnSelect([B.getID()]);
    C.cancelBubble = true;
    SimileAjax.DOM.cancelEvent(C);
    return false;
};
Timeline.CompactEventPainter.prototype.showBubble = function (A) {
    var B = this._eventIdToElmt[A.getID()];
    if (B) {
        var C = SimileAjax.DOM.getPageCoordinates(B);
        this._showBubble(C.left + B.offsetWidth / 2, C.top + B.offsetHeight / 2, [A]);
    }
};
Timeline.CompactEventPainter.prototype._showBubble = function (A, F, B) {
    var E = document.createElement("div");
    B = ("fillInfoBubble" in B) ? [B] : B;
    for (var D = 0;
         D < B.length;
         D++) {
        var C = document.createElement("div");
        E.appendChild(C);
        B[D].fillInfoBubble(C, this._params.theme, this._band.getLabeller());
    }
    SimileAjax.WindowManager.cancelPopups();
    SimileAjax.Graphics.createBubbleForContentAndPoint(E, A, F, this._params.theme.event.bubble.width);
};
Timeline.CompactEventPainter.prototype._fireOnSelect = function (B) {
    for (var A = 0;
         A < this._onSelectListeners.length;
         A++) {
        this._onSelectListeners[A](B);
    }
};


/* decorators.js */
Timeline.SpanHighlightDecorator = function (A) {
    this._unit = A.unit != null ? A.unit : SimileAjax.NativeDateUnit;
    this._startDate = (typeof A.startDate == "string") ? this._unit.parseFromObject(A.startDate) : A.startDate;
    this._endDate = (typeof A.endDate == "string") ? this._unit.parseFromObject(A.endDate) : A.endDate;
    this._startLabel = A.startLabel != null ? A.startLabel : "";
    this._endLabel = A.endLabel != null ? A.endLabel : "";
    this._color = A.color;
    this._cssClass = A.cssClass != null ? A.cssClass : null;
    this._opacity = A.opacity != null ? A.opacity : 100;
    this._zIndex = (A.inFront != null && A.inFront) ? 113 : 10;
};
Timeline.SpanHighlightDecorator.prototype.initialize = function (B, A) {
    this._band = B;
    this._timeline = A;
    this._layerDiv = null;
};
Timeline.SpanHighlightDecorator.prototype.paint = function () {
    if (this._layerDiv != null) {
        this._band.removeLayerDiv(this._layerDiv);
    }
    this._layerDiv = this._band.createLayerDiv(this._zIndex);
    this._layerDiv.setAttribute("name", "span-highlight-decorator");
    this._layerDiv.style.display = "none";
    var F = this._band.getMinDate();
    var C = this._band.getMaxDate();
    if (this._unit.compare(this._startDate, C) < 0 && this._unit.compare(this._endDate, F) > 0) {
        F = this._unit.later(F, this._startDate);
        C = this._unit.earlier(C, this._endDate);
        var D = this._band.dateToPixelOffset(F);
        var K = this._band.dateToPixelOffset(C);
        var I = this._timeline.getDocument();
        var H = function () {
            var L = I.createElement("table");
            L.insertRow(0).insertCell(0);
            return L;
        };
        var B = I.createElement("div");
        B.className = "timeline-highlight-decorator";
        if (this._cssClass) {
            B.className += " " + this._cssClass;
        }
        if (this._color != null) {
            B.style.backgroundColor = this._color;
        }
        if (this._opacity < 100) {
            SimileAjax.Graphics.setOpacity(B, this._opacity);
        }
        this._layerDiv.appendChild(B);
        var J = H();
        J.className = "timeline-highlight-label timeline-highlight-label-start";
        var G = J.rows[0].cells[0];
        G.innerHTML = this._startLabel;
        if (this._cssClass) {
            G.className = "label_" + this._cssClass;
        }
        this._layerDiv.appendChild(J);
        var A = H();
        A.className = "timeline-highlight-label timeline-highlight-label-end";
        var E = A.rows[0].cells[0];
        E.innerHTML = this._endLabel;
        if (this._cssClass) {
            E.className = "label_" + this._cssClass;
        }
        this._layerDiv.appendChild(A);
        if (this._timeline.isHorizontal()) {
            B.style.left = D + "px";
            B.style.width = (K - D) + "px";
            J.style.right = (this._band.getTotalViewLength() - D) + "px";
            J.style.width = (this._startLabel.length) + "em";
            A.style.left = K + "px";
            A.style.width = (this._endLabel.length) + "em";
        } else {
            B.style.top = D + "px";
            B.style.height = (K - D) + "px";
            J.style.bottom = D + "px";
            J.style.height = "1.5px";
            A.style.top = K + "px";
            A.style.height = "1.5px";
        }
    }
    this._layerDiv.style.display = "block";
};
Timeline.SpanHighlightDecorator.prototype.softPaint = function () {
};
Timeline.PointHighlightDecorator = function (A) {
    this._unit = A.unit != null ? A.unit : SimileAjax.NativeDateUnit;
    this._date = (typeof A.date == "string") ? this._unit.parseFromObject(A.date) : A.date;
    this._width = A.width != null ? A.width : 10;
    this._color = A.color;
    this._cssClass = A.cssClass != null ? A.cssClass : "";
    this._opacity = A.opacity != null ? A.opacity : 100;
};
Timeline.PointHighlightDecorator.prototype.initialize = function (B, A) {
    this._band = B;
    this._timeline = A;
    this._layerDiv = null;
};
Timeline.PointHighlightDecorator.prototype.paint = function () {
    if (this._layerDiv != null) {
        this._band.removeLayerDiv(this._layerDiv);
    }
    this._layerDiv = this._band.createLayerDiv(10);
    this._layerDiv.setAttribute("name", "span-highlight-decorator");
    this._layerDiv.style.display = "none";
    var C = this._band.getMinDate();
    var E = this._band.getMaxDate();
    if (this._unit.compare(this._date, E) < 0 && this._unit.compare(this._date, C) > 0) {
        var B = this._band.dateToPixelOffset(this._date);
        var A = B - Math.round(this._width / 2);
        var D = this._timeline.getDocument();
        var F = D.createElement("div");
        F.className = "timeline-highlight-point-decorator";
        F.className += " " + this._cssClass;
        if (this._color != null) {
            F.style.backgroundColor = this._color;
        }
        if (this._opacity < 100) {
            SimileAjax.Graphics.setOpacity(F, this._opacity);
        }
        this._layerDiv.appendChild(F);
        if (this._timeline.isHorizontal()) {
            F.style.left = A + "px";
            F.style.width = this._width;
        } else {
            F.style.top = A + "px";
            F.style.height = this._width;
        }
    }
    this._layerDiv.style.display = "block";
};
Timeline.PointHighlightDecorator.prototype.softPaint = function () {
};


/* detailed-painter.js */
Timeline.DetailedEventPainter = function (A) {
    this._params = A;
    this._onSelectListeners = [];
    this._filterMatcher = null;
    this._highlightMatcher = null;
    this._frc = null;
    this._eventIdToElmt = {};
};
Timeline.DetailedEventPainter.prototype.initialize = function (B, A) {
    this._band = B;
    this._timeline = A;
    this._backLayer = null;
    this._eventLayer = null;
    this._lineLayer = null;
    this._highlightLayer = null;
    this._eventIdToElmt = null;
};
Timeline.DetailedEventPainter.prototype.getType = function () {
    return "detailed";
};
Timeline.DetailedEventPainter.prototype.addOnSelectListener = function (A) {
    this._onSelectListeners.push(A);
};
Timeline.DetailedEventPainter.prototype.removeOnSelectListener = function (B) {
    for (var A = 0;
         A < this._onSelectListeners.length;
         A++) {
        if (this._onSelectListeners[A] == B) {
            this._onSelectListeners.splice(A, 1);
            break;
        }
    }
};
Timeline.DetailedEventPainter.prototype.getFilterMatcher = function () {
    return this._filterMatcher;
};
Timeline.DetailedEventPainter.prototype.setFilterMatcher = function (A) {
    this._filterMatcher = A;
};
Timeline.DetailedEventPainter.prototype.getHighlightMatcher = function () {
    return this._highlightMatcher;
};
Timeline.DetailedEventPainter.prototype.setHighlightMatcher = function (A) {
    this._highlightMatcher = A;
};
Timeline.DetailedEventPainter.prototype.paint = function () {
    var B = this._band.getEventSource();
    if (B == null) {
        return;
    }
    this._eventIdToElmt = {};
    this._prepareForPainting();
    var I = this._params.theme.event;
    var G = Math.max(I.track.height, this._frc.getLineHeight());
    var F = {
        trackOffset: Math.round(this._band.getViewWidth() / 2 - G / 2),
        trackHeight: G,
        trackGap: I.track.gap,
        trackIncrement: G + I.track.gap,
        icon: I.instant.icon,
        iconWidth: I.instant.iconWidth,
        iconHeight: I.instant.iconHeight,
        labelWidth: I.label.width
    };
    var C = this._band.getMinDate();
    var A = this._band.getMaxDate();
    var J = (this._filterMatcher != null) ? this._filterMatcher : function (K) {
        return true;
    };
    var E = (this._highlightMatcher != null) ? this._highlightMatcher : function (K) {
        return -1;
    };
    var D = B.getEventReverseIterator(C, A);
    while (D.hasNext()) {
        var H = D.next();
        if (J(H)) {
            this.paintEvent(H, F, this._params.theme, E(H));
        }
    }
    this._highlightLayer.style.display = "block";
    this._lineLayer.style.display = "block";
    this._eventLayer.style.display = "block";
    this._band.updateEventTrackInfo(this._lowerTracks.length + this._upperTracks.length, F.trackIncrement);
};
Timeline.DetailedEventPainter.prototype.softPaint = function () {
};
Timeline.DetailedEventPainter.prototype._prepareForPainting = function () {
    var B = this._band;
    if (this._backLayer == null) {
        this._backLayer = this._band.createLayerDiv(0, "timeline-band-events");
        this._backLayer.style.visibility = "hidden";
        var A = document.createElement("span");
        A.className = "timeline-event-label";
        this._backLayer.appendChild(A);
        this._frc = SimileAjax.Graphics.getFontRenderingContext(A);
    }
    this._frc.update();
    this._lowerTracks = [];
    this._upperTracks = [];
    if (this._highlightLayer != null) {
        B.removeLayerDiv(this._highlightLayer);
    }
    this._highlightLayer = B.createLayerDiv(105, "timeline-band-highlights");
    this._highlightLayer.style.display = "none";
    if (this._lineLayer != null) {
        B.removeLayerDiv(this._lineLayer);
    }
    this._lineLayer = B.createLayerDiv(110, "timeline-band-lines");
    this._lineLayer.style.display = "none";
    if (this._eventLayer != null) {
        B.removeLayerDiv(this._eventLayer);
    }
    this._eventLayer = B.createLayerDiv(110, "timeline-band-events");
    this._eventLayer.style.display = "none";
};
Timeline.DetailedEventPainter.prototype.paintEvent = function (B, C, D, A) {
    if (B.isInstant()) {
        this.paintInstantEvent(B, C, D, A);
    } else {
        this.paintDurationEvent(B, C, D, A);
    }
};
Timeline.DetailedEventPainter.prototype.paintInstantEvent = function (B, C, D, A) {
    if (B.isImprecise()) {
        this.paintImpreciseInstantEvent(B, C, D, A);
    } else {
        this.paintPreciseInstantEvent(B, C, D, A);
    }
};
Timeline.DetailedEventPainter.prototype.paintDurationEvent = function (B, C, D, A) {
    if (B.isImprecise()) {
        this.paintImpreciseDurationEvent(B, C, D, A);
    } else {
        this.paintPreciseDurationEvent(B, C, D, A);
    }
};
Timeline.DetailedEventPainter.prototype.paintPreciseInstantEvent = function (K, N, Q, O) {
    var S = this._timeline.getDocument();
    var J = K.getText();
    var E = K.getStart();
    var C = Math.round(this._band.dateToPixelOffset(E));
    var A = Math.round(C + N.iconWidth / 2);
    var I = Math.round(C - N.iconWidth / 2);
    var G = this._frc.computeSize(J);
    var D = this._findFreeTrackForSolid(A, C);
    var B = this._paintEventIcon(K, D, I, N, Q);
    var T = A + Q.event.label.offsetFromLine;
    var P = D;
    var F = this._getTrackData(D);
    if (Math.min(F.solid, F.text) >= T + G.width) {
        F.solid = I;
        F.text = T;
    } else {
        F.solid = I;
        T = C + Q.event.label.offsetFromLine;
        P = this._findFreeTrackForText(D, T + G.width, function (U) {
            U.line = C - 2;
        });
        this._getTrackData(P).text = I;
        this._paintEventLine(K, C, D, P, N, Q);
    }
    var R = Math.round(N.trackOffset + P * N.trackIncrement + N.trackHeight / 2 - G.height / 2);
    var M = this._paintEventLabel(K, J, T, R, G.width, G.height, Q);
    var L = this;
    var H = function (U, V, W) {
        return L._onClickInstantEvent(B.elmt, V, K);
    };
    SimileAjax.DOM.registerEvent(B.elmt, "mousedown", H);
    SimileAjax.DOM.registerEvent(M.elmt, "mousedown", H);
    this._createHighlightDiv(O, B, Q);
    this._eventIdToElmt[K.getID()] = B.elmt;
};
Timeline.DetailedEventPainter.prototype.paintImpreciseInstantEvent = function (N, Q, V, R) {
    var X = this._timeline.getDocument();
    var M = N.getText();
    var H = N.getStart();
    var S = N.getEnd();
    var E = Math.round(this._band.dateToPixelOffset(H));
    var B = Math.round(this._band.dateToPixelOffset(S));
    var A = Math.round(E + Q.iconWidth / 2);
    var L = Math.round(E - Q.iconWidth / 2);
    var J = this._frc.computeSize(M);
    var F = this._findFreeTrackForSolid(B, E);
    var G = this._paintEventTape(N, F, E, B, V.event.instant.impreciseColor, V.event.instant.impreciseOpacity, Q, V);
    var C = this._paintEventIcon(N, F, L, Q, V);
    var I = this._getTrackData(F);
    I.solid = L;
    var W = A + V.event.label.offsetFromLine;
    var D = W + J.width;
    var T;
    if (D < B) {
        T = F;
    } else {
        W = E + V.event.label.offsetFromLine;
        D = W + J.width;
        T = this._findFreeTrackForText(F, D, function (Y) {
            Y.line = E - 2;
        });
        this._getTrackData(T).text = L;
        this._paintEventLine(N, E, F, T, Q, V);
    }
    var U = Math.round(Q.trackOffset + T * Q.trackIncrement + Q.trackHeight / 2 - J.height / 2);
    var P = this._paintEventLabel(N, M, W, U, J.width, J.height, V);
    var O = this;
    var K = function (Y, Z, a) {
        return O._onClickInstantEvent(C.elmt, Z, N);
    };
    SimileAjax.DOM.registerEvent(C.elmt, "mousedown", K);
    SimileAjax.DOM.registerEvent(G.elmt, "mousedown", K);
    SimileAjax.DOM.registerEvent(P.elmt, "mousedown", K);
    this._createHighlightDiv(R, C, V);
    this._eventIdToElmt[N.getID()] = C.elmt;
};
Timeline.DetailedEventPainter.prototype.paintPreciseDurationEvent = function (J, M, S, O) {
    var T = this._timeline.getDocument();
    var I = J.getText();
    var D = J.getStart();
    var P = J.getEnd();
    var B = Math.round(this._band.dateToPixelOffset(D));
    var A = Math.round(this._band.dateToPixelOffset(P));
    var F = this._frc.computeSize(I);
    var E = this._findFreeTrackForSolid(A);
    var N = J.getColor();
    N = N != null ? N : S.event.duration.color;
    var C = this._paintEventTape(J, E, B, A, N, 100, M, S);
    var H = this._getTrackData(E);
    H.solid = B;
    var U = B + S.event.label.offsetFromLine;
    var Q = this._findFreeTrackForText(E, U + F.width, function (V) {
        V.line = B - 2;
    });
    this._getTrackData(Q).text = B - 2;
    this._paintEventLine(J, B, E, Q, M, S);
    var R = Math.round(M.trackOffset + Q * M.trackIncrement + M.trackHeight / 2 - F.height / 2);
    var L = this._paintEventLabel(J, I, U, R, F.width, F.height, S);
    var K = this;
    var G = function (V, W, X) {
        return K._onClickDurationEvent(C.elmt, W, J);
    };
    SimileAjax.DOM.registerEvent(C.elmt, "mousedown", G);
    SimileAjax.DOM.registerEvent(L.elmt, "mousedown", G);
    this._createHighlightDiv(O, C, S);
    this._eventIdToElmt[J.getID()] = C.elmt;
};
Timeline.DetailedEventPainter.prototype.paintImpreciseDurationEvent = function (L, P, W, S) {
    var Z = this._timeline.getDocument();
    var K = L.getText();
    var D = L.getStart();
    var Q = L.getLatestStart();
    var T = L.getEnd();
    var X = L.getEarliestEnd();
    var B = Math.round(this._band.dateToPixelOffset(D));
    var F = Math.round(this._band.dateToPixelOffset(Q));
    var A = Math.round(this._band.dateToPixelOffset(T));
    var G = Math.round(this._band.dateToPixelOffset(X));
    var H = this._frc.computeSize(K);
    var E = this._findFreeTrackForSolid(A);
    var R = L.getColor();
    R = R != null ? R : W.event.duration.color;
    var O = this._paintEventTape(L, E, B, A, W.event.duration.impreciseColor, W.event.duration.impreciseOpacity, P, W);
    var C = this._paintEventTape(L, E, F, G, R, 100, P, W);
    var J = this._getTrackData(E);
    J.solid = B;
    var Y = F + W.event.label.offsetFromLine;
    var U = this._findFreeTrackForText(E, Y + H.width, function (a) {
        a.line = F - 2;
    });
    this._getTrackData(U).text = F - 2;
    this._paintEventLine(L, F, E, U, P, W);
    var V = Math.round(P.trackOffset + U * P.trackIncrement + P.trackHeight / 2 - H.height / 2);
    var N = this._paintEventLabel(L, K, Y, V, H.width, H.height, W);
    var M = this;
    var I = function (a, b, c) {
        return M._onClickDurationEvent(C.elmt, b, L);
    };
    SimileAjax.DOM.registerEvent(C.elmt, "mousedown", I);
    SimileAjax.DOM.registerEvent(N.elmt, "mousedown", I);
    this._createHighlightDiv(S, C, W);
    this._eventIdToElmt[L.getID()] = C.elmt;
};
Timeline.DetailedEventPainter.prototype._findFreeTrackForSolid = function (B, A) {
    for (var D = 0;
         true;
         D++) {
        if (D < this._lowerTracks.length) {
            var C = this._lowerTracks[D];
            if (Math.min(C.solid, C.text) > B && (!(A) || C.line > A)) {
                return D;
            }
        } else {
            this._lowerTracks.push({solid: Number.POSITIVE_INFINITY, text: Number.POSITIVE_INFINITY, line: Number.POSITIVE_INFINITY});
            return D;
        }
        if (D < this._upperTracks.length) {
            var C = this._upperTracks[D];
            if (Math.min(C.solid, C.text) > B && (!(A) || C.line > A)) {
                return -1 - D;
            }
        } else {
            this._upperTracks.push({solid: Number.POSITIVE_INFINITY, text: Number.POSITIVE_INFINITY, line: Number.POSITIVE_INFINITY});
            return -1 - D;
        }
    }
};
Timeline.DetailedEventPainter.prototype._findFreeTrackForText = function (D, C, H) {
    var F;
    var G;
    var B;
    var J;
    if (D < 0) {
        F = true;
        B = -D;
        G = this._findFreeUpperTrackForText(B, C);
        J = -1 - G;
    } else {
        if (D > 0) {
            F = false;
            B = D + 1;
            G = this._findFreeLowerTrackForText(B, C);
            J = G;
        } else {
            var A = this._findFreeUpperTrackForText(0, C);
            var I = this._findFreeLowerTrackForText(1, C);
            if (I - 1 <= A) {
                F = false;
                B = 1;
                G = I;
                J = G;
            } else {
                F = true;
                B = 0;
                G = A;
                J = -1 - G;
            }
        }
    }
    if (F) {
        if (G == this._upperTracks.length) {
            this._upperTracks.push({solid: Number.POSITIVE_INFINITY, text: Number.POSITIVE_INFINITY, line: Number.POSITIVE_INFINITY});
        }
        for (var E = B;
             E < G;
             E++) {
            H(this._upperTracks[E]);
        }
    } else {
        if (G == this._lowerTracks.length) {
            this._lowerTracks.push({solid: Number.POSITIVE_INFINITY, text: Number.POSITIVE_INFINITY, line: Number.POSITIVE_INFINITY});
        }
        for (var E = B;
             E < G;
             E++) {
            H(this._lowerTracks[E]);
        }
    }
    return J;
};
Timeline.DetailedEventPainter.prototype._findFreeLowerTrackForText = function (A, C) {
    for (;
        A < this._lowerTracks.length;
        A++) {
        var B = this._lowerTracks[A];
        if (Math.min(B.solid, B.text) >= C) {
            break;
        }
    }
    return A;
};
Timeline.DetailedEventPainter.prototype._findFreeUpperTrackForText = function (A, C) {
    for (;
        A < this._upperTracks.length;
        A++) {
        var B = this._upperTracks[A];
        if (Math.min(B.solid, B.text) >= C) {
            break;
        }
    }
    return A;
};
Timeline.DetailedEventPainter.prototype._getTrackData = function (A) {
    return (A < 0) ? this._upperTracks[-A - 1] : this._lowerTracks[A];
};
Timeline.DetailedEventPainter.prototype._paintEventLine = function (I, C, F, A, G, D) {
    var H = Math.round(G.trackOffset + F * G.trackIncrement + G.trackHeight / 2);
    var J = Math.round(Math.abs(A - F) * G.trackIncrement);
    var E = "1px solid " + D.event.label.lineColor;
    var B = this._timeline.getDocument().createElement("div");
    B.style.position = "absolute";
    B.style.left = C + "px";
    B.style.width = D.event.label.offsetFromLine + "px";
    B.style.height = J + "px";
    if (F > A) {
        B.style.top = (H - J) + "px";
        B.style.borderTop = E;
    } else {
        B.style.top = H + "px";
        B.style.borderBottom = E;
    }
    B.style.borderLeft = E;
    this._lineLayer.appendChild(B);
};
Timeline.DetailedEventPainter.prototype._paintEventIcon = function (I, E, B, F, D) {
    var H = I.getIcon();
    H = H != null ? H : F.icon;
    var J = F.trackOffset + E * F.trackIncrement + F.trackHeight / 2;
    var G = Math.round(J - F.iconHeight / 2);
    var C = SimileAjax.Graphics.createTranslucentImage(H);
    var A = this._timeline.getDocument().createElement("div");
    A.style.position = "absolute";
    A.style.left = B + "px";
    A.style.top = G + "px";
    A.appendChild(C);
    A.style.cursor = "pointer";
    if (I._title != null) {
        A.title = I._title;
    }
    this._eventLayer.appendChild(A);
    return {left: B, top: G, width: F.iconWidth, height: F.iconHeight, elmt: A};
};
Timeline.DetailedEventPainter.prototype._paintEventLabel = function (H, I, B, F, A, J, D) {
    var G = this._timeline.getDocument();
    var K = G.createElement("div");
    K.style.position = "absolute";
    K.style.left = B + "px";
    K.style.width = A + "px";
    K.style.top = F + "px";
    K.style.height = J + "px";
    K.style.backgroundColor = D.event.label.backgroundColor;
    SimileAjax.Graphics.setOpacity(K, D.event.label.backgroundOpacity);
    this._eventLayer.appendChild(K);
    var E = G.createElement("div");
    E.style.position = "absolute";
    E.style.left = B + "px";
    E.style.width = A + "px";
    E.style.top = F + "px";
    E.innerHTML = I;
    E.style.cursor = "pointer";
    if (H._title != null) {
        E.title = H._title;
    }
    var C = H.getTextColor();
    if (C == null) {
        C = H.getColor();
    }
    if (C != null) {
        E.style.color = C;
    }
    this._eventLayer.appendChild(E);
    return {left: B, top: F, width: A, height: J, elmt: E};
};
Timeline.DetailedEventPainter.prototype._paintEventTape = function (L, H, E, A, C, G, I, F) {
    var B = A - E;
    var D = F.event.tape.height;
    var M = I.trackOffset + H * I.trackIncrement + I.trackHeight / 2;
    var J = Math.round(M - D / 2);
    var K = this._timeline.getDocument().createElement("div");
    K.style.position = "absolute";
    K.style.left = E + "px";
    K.style.width = B + "px";
    K.style.top = J + "px";
    K.style.height = D + "px";
    K.style.backgroundColor = C;
    K.style.overflow = "hidden";
    K.style.cursor = "pointer";
    if (L._title != null) {
        K.title = L._title;
    }
    SimileAjax.Graphics.setOpacity(K, G);
    this._eventLayer.appendChild(K);
    return {left: E, top: J, width: B, height: D, elmt: K};
};
Timeline.DetailedEventPainter.prototype._createHighlightDiv = function (A, C, E) {
    if (A >= 0) {
        var D = this._timeline.getDocument();
        var G = E.event;
        var B = G.highlightColors[Math.min(A, G.highlightColors.length - 1)];
        var F = D.createElement("div");
        F.style.position = "absolute";
        F.style.overflow = "hidden";
        F.style.left = (C.left - 2) + "px";
        F.style.width = (C.width + 4) + "px";
        F.style.top = (C.top - 2) + "px";
        F.style.height = (C.height + 4) + "px";
        F.style.background = B;
        this._highlightLayer.appendChild(F);
    }
};
Timeline.DetailedEventPainter.prototype._onClickInstantEvent = function (B, C, A) {
    var D = SimileAjax.DOM.getPageCoordinates(B);
    this._showBubble(D.left + Math.ceil(B.offsetWidth / 2), D.top + Math.ceil(B.offsetHeight / 2), A);
    this._fireOnSelect(A.getID());
    C.cancelBubble = true;
    SimileAjax.DOM.cancelEvent(C);
    return false;
};
Timeline.DetailedEventPainter.prototype._onClickDurationEvent = function (D, C, B) {
    if ("pageX" in C) {
        var A = C.pageX;
        var F = C.pageY;
    } else {
        var E = SimileAjax.DOM.getPageCoordinates(D);
        var A = C.offsetX + E.left;
        var F = C.offsetY + E.top;
    }
    this._showBubble(A, F, B);
    this._fireOnSelect(B.getID());
    C.cancelBubble = true;
    SimileAjax.DOM.cancelEvent(C);
    return false;
};
Timeline.DetailedEventPainter.prototype.showBubble = function (A) {
    var B = this._eventIdToElmt[A.getID()];
    if (B) {
        var C = SimileAjax.DOM.getPageCoordinates(B);
        this._showBubble(C.left + B.offsetWidth / 2, C.top + B.offsetHeight / 2, A);
    }
};
Timeline.DetailedEventPainter.prototype._showBubble = function (A, E, B) {
    var D = document.createElement("div");
    var C = this._params.theme.event.bubble;
    B.fillInfoBubble(D, this._params.theme, this._band.getLabeller());
    SimileAjax.WindowManager.cancelPopups();
    SimileAjax.Graphics.createBubbleForContentAndPoint(D, A, E, C.width, null, C.maxHeight);
};
Timeline.DetailedEventPainter.prototype._fireOnSelect = function (B) {
    for (var A = 0;
         A < this._onSelectListeners.length;
         A++) {
        this._onSelectListeners[A](B);
    }
};


/* ether-painters.js */
Timeline.GregorianEtherPainter = function (A) {
    this._params = A;
    this._theme = A.theme;
    this._unit = A.unit;
    this._multiple = ("multiple" in A) ? A.multiple : 1;
};
Timeline.GregorianEtherPainter.prototype.initialize = function (C, B) {
    this._band = C;
    this._timeline = B;
    this._backgroundLayer = C.createLayerDiv(0);
    this._backgroundLayer.setAttribute("name", "ether-background");
    this._backgroundLayer.className = "timeline-ether-bg";
    this._markerLayer = null;
    this._lineLayer = null;
    var D = ("align" in this._params && this._params.align != undefined) ? this._params.align : this._theme.ether.interval.marker[B.isHorizontal() ? "hAlign" : "vAlign"];
    var A = ("showLine" in this._params) ? this._params.showLine : this._theme.ether.interval.line.show;
    this._intervalMarkerLayout = new Timeline.EtherIntervalMarkerLayout(this._timeline, this._band, this._theme, D, A);
    this._highlight = new Timeline.EtherHighlight(this._timeline, this._band, this._theme, this._backgroundLayer);
};
Timeline.GregorianEtherPainter.prototype.setHighlight = function (A, B) {
    this._highlight.position(A, B);
};
Timeline.GregorianEtherPainter.prototype.paint = function () {
    if (this._markerLayer) {
        this._band.removeLayerDiv(this._markerLayer);
    }
    this._markerLayer = this._band.createLayerDiv(100);
    this._markerLayer.setAttribute("name", "ether-markers");
    this._markerLayer.style.display = "none";
    if (this._lineLayer) {
        this._band.removeLayerDiv(this._lineLayer);
    }
    this._lineLayer = this._band.createLayerDiv(1);
    this._lineLayer.setAttribute("name", "ether-lines");
    this._lineLayer.style.display = "none";
    var C = this._band.getMinDate();
    var F = this._band.getMaxDate();
    var B = this._band.getTimeZone();
    var E = this._band.getLabeller();
    SimileAjax.DateTime.roundDownToInterval(C, this._unit, B, this._multiple, this._theme.firstDayOfWeek);
    var D = this;
    var A = function (G) {
        for (var H = 0;
             H < D._multiple;
             H++) {
            SimileAjax.DateTime.incrementByInterval(G, D._unit);
        }
    };
    while (C.getTime() < F.getTime()) {
        this._intervalMarkerLayout.createIntervalMarker(C, E, this._unit, this._markerLayer, this._lineLayer);
        A(C);
    }
    this._markerLayer.style.display = "block";
    this._lineLayer.style.display = "block";
};
Timeline.GregorianEtherPainter.prototype.softPaint = function () {
};
Timeline.GregorianEtherPainter.prototype.zoom = function (A) {
    if (A != 0) {
        this._unit += A;
    }
};
Timeline.HotZoneGregorianEtherPainter = function (G) {
    this._params = G;
    this._theme = G.theme;
    this._zones = [{startTime: Number.NEGATIVE_INFINITY, endTime: Number.POSITIVE_INFINITY, unit: G.unit, multiple: 1}];
    for (var E = 0;
         E < G.zones.length;
         E++) {
        var B = G.zones[E];
        var D = SimileAjax.DateTime.parseGregorianDateTime(B.start).getTime();
        var F = SimileAjax.DateTime.parseGregorianDateTime(B.end).getTime();
        for (var C = 0;
             C < this._zones.length && F > D;
             C++) {
            var A = this._zones[C];
            if (D < A.endTime) {
                if (D > A.startTime) {
                    this._zones.splice(C, 0, {startTime: A.startTime, endTime: D, unit: A.unit, multiple: A.multiple});
                    C++;
                    A.startTime = D;
                }
                if (F < A.endTime) {
                    this._zones.splice(C, 0, {startTime: D, endTime: F, unit: B.unit, multiple: (B.multiple) ? B.multiple : 1});
                    C++;
                    A.startTime = F;
                    D = F;
                } else {
                    A.multiple = B.multiple;
                    A.unit = B.unit;
                    D = A.endTime;
                }
            }
        }
    }
};
Timeline.HotZoneGregorianEtherPainter.prototype.initialize = function (C, B) {
    this._band = C;
    this._timeline = B;
    this._backgroundLayer = C.createLayerDiv(0);
    this._backgroundLayer.setAttribute("name", "ether-background");
    this._backgroundLayer.className = "timeline-ether-bg";
    this._markerLayer = null;
    this._lineLayer = null;
    var D = ("align" in this._params && this._params.align != undefined) ? this._params.align : this._theme.ether.interval.marker[B.isHorizontal() ? "hAlign" : "vAlign"];
    var A = ("showLine" in this._params) ? this._params.showLine : this._theme.ether.interval.line.show;
    this._intervalMarkerLayout = new Timeline.EtherIntervalMarkerLayout(this._timeline, this._band, this._theme, D, A);
    this._highlight = new Timeline.EtherHighlight(this._timeline, this._band, this._theme, this._backgroundLayer);
};
Timeline.HotZoneGregorianEtherPainter.prototype.setHighlight = function (A, B) {
    this._highlight.position(A, B);
};
Timeline.HotZoneGregorianEtherPainter.prototype.paint = function () {
    if (this._markerLayer) {
        this._band.removeLayerDiv(this._markerLayer);
    }
    this._markerLayer = this._band.createLayerDiv(100);
    this._markerLayer.setAttribute("name", "ether-markers");
    this._markerLayer.style.display = "none";
    if (this._lineLayer) {
        this._band.removeLayerDiv(this._lineLayer);
    }
    this._lineLayer = this._band.createLayerDiv(1);
    this._lineLayer.setAttribute("name", "ether-lines");
    this._lineLayer.style.display = "none";
    var D = this._band.getMinDate();
    var A = this._band.getMaxDate();
    var K = this._band.getTimeZone();
    var I = this._band.getLabeller();
    var B = this;
    var L = function (N, M) {
        for (var O = 0;
             O < M.multiple;
             O++) {
            SimileAjax.DateTime.incrementByInterval(N, M.unit);
        }
    };
    var C = 0;
    while (C < this._zones.length) {
        if (D.getTime() < this._zones[C].endTime) {
            break;
        }
        C++;
    }
    var E = this._zones.length - 1;
    while (E >= 0) {
        if (A.getTime() > this._zones[E].startTime) {
            break;
        }
        E--;
    }
    for (var H = C;
         H <= E;
         H++) {
        var G = this._zones[H];
        var J = new Date(Math.max(D.getTime(), G.startTime));
        var F = new Date(Math.min(A.getTime(), G.endTime));
        SimileAjax.DateTime.roundDownToInterval(J, G.unit, K, G.multiple, this._theme.firstDayOfWeek);
        SimileAjax.DateTime.roundUpToInterval(F, G.unit, K, G.multiple, this._theme.firstDayOfWeek);
        while (J.getTime() < F.getTime()) {
            this._intervalMarkerLayout.createIntervalMarker(J, I, G.unit, this._markerLayer, this._lineLayer);
            L(J, G);
        }
    }
    this._markerLayer.style.display = "block";
    this._lineLayer.style.display = "block";
};
Timeline.HotZoneGregorianEtherPainter.prototype.softPaint = function () {
};
Timeline.HotZoneGregorianEtherPainter.prototype.zoom = function (B) {
    if (B != 0) {
        for (var A = 0;
             A < this._zones.length;
             ++A) {
            if (this._zones[A]) {
                this._zones[A].unit += B;
            }
        }
    }
};
Timeline.YearCountEtherPainter = function (A) {
    this._params = A;
    this._theme = A.theme;
    this._startDate = SimileAjax.DateTime.parseGregorianDateTime(A.startDate);
    this._multiple = ("multiple" in A) ? A.multiple : 1;
};
Timeline.YearCountEtherPainter.prototype.initialize = function (C, B) {
    this._band = C;
    this._timeline = B;
    this._backgroundLayer = C.createLayerDiv(0);
    this._backgroundLayer.setAttribute("name", "ether-background");
    this._backgroundLayer.className = "timeline-ether-bg";
    this._markerLayer = null;
    this._lineLayer = null;
    var D = ("align" in this._params) ? this._params.align : this._theme.ether.interval.marker[B.isHorizontal() ? "hAlign" : "vAlign"];
    var A = ("showLine" in this._params) ? this._params.showLine : this._theme.ether.interval.line.show;
    this._intervalMarkerLayout = new Timeline.EtherIntervalMarkerLayout(this._timeline, this._band, this._theme, D, A);
    this._highlight = new Timeline.EtherHighlight(this._timeline, this._band, this._theme, this._backgroundLayer);
};
Timeline.YearCountEtherPainter.prototype.setHighlight = function (A, B) {
    this._highlight.position(A, B);
};
Timeline.YearCountEtherPainter.prototype.paint = function () {
    if (this._markerLayer) {
        this._band.removeLayerDiv(this._markerLayer);
    }
    this._markerLayer = this._band.createLayerDiv(100);
    this._markerLayer.setAttribute("name", "ether-markers");
    this._markerLayer.style.display = "none";
    if (this._lineLayer) {
        this._band.removeLayerDiv(this._lineLayer);
    }
    this._lineLayer = this._band.createLayerDiv(1);
    this._lineLayer.setAttribute("name", "ether-lines");
    this._lineLayer.style.display = "none";
    var B = new Date(this._startDate.getTime());
    var F = this._band.getMaxDate();
    var E = this._band.getMinDate().getUTCFullYear() - this._startDate.getUTCFullYear();
    B.setUTCFullYear(this._band.getMinDate().getUTCFullYear() - E % this._multiple);
    var C = this;
    var A = function (G) {
        for (var H = 0;
             H < C._multiple;
             H++) {
            SimileAjax.DateTime.incrementByInterval(G, SimileAjax.DateTime.YEAR);
        }
    };
    var D = {
        labelInterval: function (G, I) {
            var H = G.getUTCFullYear() - C._startDate.getUTCFullYear();
            return {text: H, emphasized: H == 0};
        }
    };
    while (B.getTime() < F.getTime()) {
        this._intervalMarkerLayout.createIntervalMarker(B, D, SimileAjax.DateTime.YEAR, this._markerLayer, this._lineLayer);
        A(B);
    }
    this._markerLayer.style.display = "block";
    this._lineLayer.style.display = "block";
};
Timeline.YearCountEtherPainter.prototype.softPaint = function () {
};
Timeline.QuarterlyEtherPainter = function (A) {
    this._params = A;
    this._theme = A.theme;
    this._startDate = SimileAjax.DateTime.parseGregorianDateTime(A.startDate);
};
Timeline.QuarterlyEtherPainter.prototype.initialize = function (C, B) {
    this._band = C;
    this._timeline = B;
    this._backgroundLayer = C.createLayerDiv(0);
    this._backgroundLayer.setAttribute("name", "ether-background");
    this._backgroundLayer.className = "timeline-ether-bg";
    this._markerLayer = null;
    this._lineLayer = null;
    var D = ("align" in this._params) ? this._params.align : this._theme.ether.interval.marker[B.isHorizontal() ? "hAlign" : "vAlign"];
    var A = ("showLine" in this._params) ? this._params.showLine : this._theme.ether.interval.line.show;
    this._intervalMarkerLayout = new Timeline.EtherIntervalMarkerLayout(this._timeline, this._band, this._theme, D, A);
    this._highlight = new Timeline.EtherHighlight(this._timeline, this._band, this._theme, this._backgroundLayer);
};
Timeline.QuarterlyEtherPainter.prototype.setHighlight = function (A, B) {
    this._highlight.position(A, B);
};
Timeline.QuarterlyEtherPainter.prototype.paint = function () {
    if (this._markerLayer) {
        this._band.removeLayerDiv(this._markerLayer);
    }
    this._markerLayer = this._band.createLayerDiv(100);
    this._markerLayer.setAttribute("name", "ether-markers");
    this._markerLayer.style.display = "none";
    if (this._lineLayer) {
        this._band.removeLayerDiv(this._lineLayer);
    }
    this._lineLayer = this._band.createLayerDiv(1);
    this._lineLayer.setAttribute("name", "ether-lines");
    this._lineLayer.style.display = "none";
    var B = new Date(0);
    var E = this._band.getMaxDate();
    B.setUTCFullYear(Math.max(this._startDate.getUTCFullYear(), this._band.getMinDate().getUTCFullYear()));
    B.setUTCMonth(this._startDate.getUTCMonth());
    var C = this;
    var A = function (F) {
        F.setUTCMonth(F.getUTCMonth() + 3);
    };
    var D = {
        labelInterval: function (F, H) {
            var G = (4 + (F.getUTCMonth() - C._startDate.getUTCMonth()) / 3) % 4;
            if (G != 0) {
                return {text: "Q" + (G + 1), emphasized: false};
            } else {
                return {text: "Y" + (F.getUTCFullYear() - C._startDate.getUTCFullYear() + 1), emphasized: true};
            }
        }
    };
    while (B.getTime() < E.getTime()) {
        this._intervalMarkerLayout.createIntervalMarker(B, D, SimileAjax.DateTime.YEAR, this._markerLayer, this._lineLayer);
        A(B);
    }
    this._markerLayer.style.display = "block";
    this._lineLayer.style.display = "block";
};
Timeline.QuarterlyEtherPainter.prototype.softPaint = function () {
};
Timeline.EtherIntervalMarkerLayout = function (M, L, C, E, H) {
    var A = M.isHorizontal();
    if (A) {
        if (E == "Top") {
            this.positionDiv = function (O, N) {
                O.style.left = N + "px";
                O.style.top = "0px";
            };
        } else {
            this.positionDiv = function (O, N) {
                O.style.left = N + "px";
                O.style.bottom = "0px";
            };
        }
    } else {
        if (E == "Left") {
            this.positionDiv = function (O, N) {
                O.style.top = N + "px";
                O.style.left = "0px";
            };
        } else {
            this.positionDiv = function (O, N) {
                O.style.top = N + "px";
                O.style.right = "0px";
            };
        }
    }
    var D = C.ether.interval.marker;
    var I = C.ether.interval.line;
    var B = C.ether.interval.weekend;
    var K = (A ? "h" : "v") + E;
    var G = D[K + "Styler"];
    var J = D[K + "EmphasizedStyler"];
    var F = SimileAjax.DateTime.gregorianUnitLengths[SimileAjax.DateTime.DAY];
    this.createIntervalMarker = function (T, a, b, c, Q) {
        var U = Math.round(L.dateToPixelOffset(T));
        if (H && b != SimileAjax.DateTime.WEEK) {
            var V = M.getDocument().createElement("div");
            V.className = "timeline-ether-lines";
            if (I.opacity < 100) {
                SimileAjax.Graphics.setOpacity(V, I.opacity);
            }
            if (A) {
                V.style.left = U + "px";
            } else {
                V.style.top = U + "px";
            }
            Q.appendChild(V);
        }
        if (b == SimileAjax.DateTime.WEEK) {
            var N = C.firstDayOfWeek;
            var W = new Date(T.getTime() + (6 - N - 7) * F);
            var Z = new Date(W.getTime() + 2 * F);
            var X = Math.round(L.dateToPixelOffset(W));
            var S = Math.round(L.dateToPixelOffset(Z));
            var R = Math.max(1, S - X);
            var P = M.getDocument().createElement("div");
            P.className = "timeline-ether-weekends";
            if (B.opacity < 100) {
                SimileAjax.Graphics.setOpacity(P, B.opacity);
            }
            if (A) {
                P.style.left = X + "px";
                P.style.width = R + "px";
            } else {
                P.style.top = X + "px";
                P.style.height = R + "px";
            }
            Q.appendChild(P);
        }
        var Y = a.labelInterval(T, b);
        var O = M.getDocument().createElement("div");
        O.innerHTML = Y.text;
        O.className = "timeline-date-label";
        if (Y.emphasized) {
            O.className += " timeline-date-label-em";
        }
        this.positionDiv(O, U);
        c.appendChild(O);
        return O;
    };
};
Timeline.EtherHighlight = function (C, E, D, B) {
    var A = C.isHorizontal();
    this._highlightDiv = null;
    this._createHighlightDiv = function () {
        if (this._highlightDiv == null) {
            this._highlightDiv = C.getDocument().createElement("div");
            this._highlightDiv.setAttribute("name", "ether-highlight");
            this._highlightDiv.className = "timeline-ether-highlight";
            var F = D.ether.highlightOpacity;
            if (F < 100) {
                SimileAjax.Graphics.setOpacity(this._highlightDiv, F);
            }
            B.appendChild(this._highlightDiv);
        }
    };
    this.position = function (F, I) {
        this._createHighlightDiv();
        var J = Math.round(E.dateToPixelOffset(F));
        var H = Math.round(E.dateToPixelOffset(I));
        var G = Math.max(H - J, 3);
        if (A) {
            this._highlightDiv.style.left = J + "px";
            this._highlightDiv.style.width = G + "px";
            this._highlightDiv.style.height = (E.getViewWidth() - 4) + "px";
        } else {
            this._highlightDiv.style.top = J + "px";
            this._highlightDiv.style.height = G + "px";
            this._highlightDiv.style.width = (E.getViewWidth() - 4) + "px";
        }
    };
};


/* ethers.js */
Timeline.LinearEther = function (A) {
    this._params = A;
    this._interval = A.interval;
    this._pixelsPerInterval = A.pixelsPerInterval;
};
Timeline.LinearEther.prototype.initialize = function (B, A) {
    this._band = B;
    this._timeline = A;
    this._unit = A.getUnit();
    if ("startsOn" in this._params) {
        this._start = this._unit.parseFromObject(this._params.startsOn);
    } else {
        if ("endsOn" in this._params) {
            this._start = this._unit.parseFromObject(this._params.endsOn);
            this.shiftPixels(-this._timeline.getPixelLength());
        } else {
            if ("centersOn" in this._params) {
                this._start = this._unit.parseFromObject(this._params.centersOn);
                this.shiftPixels(-this._timeline.getPixelLength() / 2);
            } else {
                this._start = this._unit.makeDefaultValue();
                this.shiftPixels(-this._timeline.getPixelLength() / 2);
            }
        }
    }
};
Timeline.LinearEther.prototype.setDate = function (A) {
    this._start = this._unit.cloneValue(A);
};
Timeline.LinearEther.prototype.shiftPixels = function (B) {
    var A = this._interval * B / this._pixelsPerInterval;
    this._start = this._unit.change(this._start, A);
};
Timeline.LinearEther.prototype.dateToPixelOffset = function (A) {
    var B = this._unit.compare(A, this._start);
    return this._pixelsPerInterval * B / this._interval;
};
Timeline.LinearEther.prototype.pixelOffsetToDate = function (B) {
    var A = B * this._interval / this._pixelsPerInterval;
    return this._unit.change(this._start, A);
};
Timeline.LinearEther.prototype.zoom = function (D) {
    var B = 0;
    var A = this._band._zoomIndex;
    var C = A;
    if (D && (A > 0)) {
        C = A - 1;
    }
    if (!D && (A < (this._band._zoomSteps.length - 1))) {
        C = A + 1;
    }
    this._band._zoomIndex = C;
    this._interval = SimileAjax.DateTime.gregorianUnitLengths[this._band._zoomSteps[C].unit];
    this._pixelsPerInterval = this._band._zoomSteps[C].pixelsPerInterval;
    B = this._band._zoomSteps[C].unit - this._band._zoomSteps[A].unit;
    return B;
};
Timeline.HotZoneEther = function (A) {
    this._params = A;
    this._interval = A.interval;
    this._pixelsPerInterval = A.pixelsPerInterval;
    this._theme = A.theme;
};
Timeline.HotZoneEther.prototype.initialize = function (H, I) {
    this._band = H;
    this._timeline = I;
    this._unit = I.getUnit();
    this._zones = [{startTime: Number.NEGATIVE_INFINITY, endTime: Number.POSITIVE_INFINITY, magnify: 1}];
    var B = this._params;
    for (var D = 0;
         D < B.zones.length;
         D++) {
        var G = B.zones[D];
        var E = this._unit.parseFromObject(G.start);
        var F = this._unit.parseFromObject(G.end);
        for (var C = 0;
             C < this._zones.length && this._unit.compare(F, E) > 0;
             C++) {
            var A = this._zones[C];
            if (this._unit.compare(E, A.endTime) < 0) {
                if (this._unit.compare(E, A.startTime) > 0) {
                    this._zones.splice(C, 0, {startTime: A.startTime, endTime: E, magnify: A.magnify});
                    C++;
                    A.startTime = E;
                }
                if (this._unit.compare(F, A.endTime) < 0) {
                    this._zones.splice(C, 0, {startTime: E, endTime: F, magnify: G.magnify * A.magnify});
                    C++;
                    A.startTime = F;
                    E = F;
                } else {
                    A.magnify *= G.magnify;
                    E = A.endTime;
                }
            }
        }
    }
    if ("startsOn" in this._params) {
        this._start = this._unit.parseFromObject(this._params.startsOn);
    } else {
        if ("endsOn" in this._params) {
            this._start = this._unit.parseFromObject(this._params.endsOn);
            this.shiftPixels(-this._timeline.getPixelLength());
        } else {
            if ("centersOn" in this._params) {
                this._start = this._unit.parseFromObject(this._params.centersOn);
                this.shiftPixels(-this._timeline.getPixelLength() / 2);
            } else {
                this._start = this._unit.makeDefaultValue();
                this.shiftPixels(-this._timeline.getPixelLength() / 2);
            }
        }
    }
};
Timeline.HotZoneEther.prototype.setDate = function (A) {
    this._start = this._unit.cloneValue(A);
};
Timeline.HotZoneEther.prototype.shiftPixels = function (A) {
    this._start = this.pixelOffsetToDate(A);
};
Timeline.HotZoneEther.prototype.dateToPixelOffset = function (A) {
    return this._dateDiffToPixelOffset(this._start, A);
};
Timeline.HotZoneEther.prototype.pixelOffsetToDate = function (A) {
    return this._pixelOffsetToDate(A, this._start);
};
Timeline.HotZoneEther.prototype.zoom = function (D) {
    var B = 0;
    var A = this._band._zoomIndex;
    var C = A;
    if (D && (A > 0)) {
        C = A - 1;
    }
    if (!D && (A < (this._band._zoomSteps.length - 1))) {
        C = A + 1;
    }
    this._band._zoomIndex = C;
    this._interval = SimileAjax.DateTime.gregorianUnitLengths[this._band._zoomSteps[C].unit];
    this._pixelsPerInterval = this._band._zoomSteps[C].pixelsPerInterval;
    B = this._band._zoomSteps[C].unit - this._band._zoomSteps[A].unit;
    return B;
};
Timeline.HotZoneEther.prototype._dateDiffToPixelOffset = function (I, D) {
    var B = this._getScale();
    var H = I;
    var C = D;
    var A = 0;
    if (this._unit.compare(H, C) < 0) {
        var G = 0;
        while (G < this._zones.length) {
            if (this._unit.compare(H, this._zones[G].endTime) < 0) {
                break;
            }
            G++;
        }
        while (this._unit.compare(H, C) < 0) {
            var E = this._zones[G];
            var F = this._unit.earlier(C, E.endTime);
            A += (this._unit.compare(F, H) / (B / E.magnify));
            H = F;
            G++;
        }
    } else {
        var G = this._zones.length - 1;
        while (G >= 0) {
            if (this._unit.compare(H, this._zones[G].startTime) > 0) {
                break;
            }
            G--;
        }
        while (this._unit.compare(H, C) > 0) {
            var E = this._zones[G];
            var F = this._unit.later(C, E.startTime);
            A += (this._unit.compare(F, H) / (B / E.magnify));
            H = F;
            G--;
        }
    }
    return A;
};
Timeline.HotZoneEther.prototype._pixelOffsetToDate = function (H, C) {
    var G = this._getScale();
    var E = C;
    if (H > 0) {
        var F = 0;
        while (F < this._zones.length) {
            if (this._unit.compare(E, this._zones[F].endTime) < 0) {
                break;
            }
            F++;
        }
        while (H > 0) {
            var A = this._zones[F];
            var D = G / A.magnify;
            if (A.endTime == Number.POSITIVE_INFINITY) {
                E = this._unit.change(E, H * D);
                H = 0;
            } else {
                var B = this._unit.compare(A.endTime, E) / D;
                if (B > H) {
                    E = this._unit.change(E, H * D);
                    H = 0;
                } else {
                    E = A.endTime;
                    H -= B;
                }
            }
            F++;
        }
    } else {
        var F = this._zones.length - 1;
        while (F >= 0) {
            if (this._unit.compare(E, this._zones[F].startTime) > 0) {
                break;
            }
            F--;
        }
        H = -H;
        while (H > 0) {
            var A = this._zones[F];
            var D = G / A.magnify;
            if (A.startTime == Number.NEGATIVE_INFINITY) {
                E = this._unit.change(E, -H * D);
                H = 0;
            } else {
                var B = this._unit.compare(E, A.startTime) / D;
                if (B > H) {
                    E = this._unit.change(E, -H * D);
                    H = 0;
                } else {
                    E = A.startTime;
                    H -= B;
                }
            }
            F--;
        }
    }
    return E;
};
Timeline.HotZoneEther.prototype._getScale = function () {
    return this._interval / this._pixelsPerInterval;
};


/* event-utils.js */
Timeline.EventUtils = {};
Timeline.EventUtils.getNewEventID = function () {
    if (this._lastEventID == null) {
        this._lastEventID = 0;
    }
    this._lastEventID += 1;
    return "e" + this._lastEventID;
};
Timeline.EventUtils.decodeEventElID = function (B) {
    var D = B.split("-");
    if (D[1] != "tl") {
        alert("Internal Timeline problem 101, please consult support");
        return {band: null, evt: null};
    }
    var C = Timeline.getTimelineFromID(D[2]);
    var E = C.getBand(D[3]);
    var A = E.getEventSource.getEvent(D[4]);
    return {band: E, evt: A};
};
Timeline.EventUtils.encodeEventElID = function (C, D, B, A) {
    return B + "-tl-" + C.timelineID + "-" + D.getIndex() + "-" + A.getID();
};


/* labellers.js */
Timeline.GregorianDateLabeller = function (A, B) {
    this._locale = A;
    this._timeZone = B;
};
Timeline.GregorianDateLabeller.monthNames = [];
Timeline.GregorianDateLabeller.dayNames = [];
Timeline.GregorianDateLabeller.labelIntervalFunctions = [];
Timeline.GregorianDateLabeller.getMonthName = function (B, A) {
    return Timeline.GregorianDateLabeller.monthNames[A][B];
};
Timeline.GregorianDateLabeller.prototype.labelInterval = function (A, C) {
    var B = Timeline.GregorianDateLabeller.labelIntervalFunctions[this._locale];
    if (B == null) {
        B = Timeline.GregorianDateLabeller.prototype.defaultLabelInterval;
    }
    return B.call(this, A, C);
};
Timeline.GregorianDateLabeller.prototype.labelPrecise = function (A) {
    return SimileAjax.DateTime.removeTimeZoneOffset(A, this._timeZone).toUTCString();
};
Timeline.GregorianDateLabeller.prototype.defaultLabelInterval = function (B, F) {
    var C;
    var E = false;
    B = SimileAjax.DateTime.removeTimeZoneOffset(B, this._timeZone);
    switch (F) {
        case SimileAjax.DateTime.MILLISECOND:
            C = B.getUTCMilliseconds();
            break;
        case SimileAjax.DateTime.SECOND:
            C = B.getUTCSeconds();
            break;
        case SimileAjax.DateTime.MINUTE:
            var A = B.getUTCMinutes();
            if (A == 0) {
                C = B.getUTCHours() + ":00";
                E = true;
            } else {
                C = A;
            }
            break;
        case SimileAjax.DateTime.HOUR:
            C = B.getUTCHours() + "hr";
            break;
        case SimileAjax.DateTime.DAY:
            C = Timeline.GregorianDateLabeller.getMonthName(B.getUTCMonth(), this._locale) + " " + B.getUTCDate();
            break;
        case SimileAjax.DateTime.WEEK:
            C = Timeline.GregorianDateLabeller.getMonthName(B.getUTCMonth(), this._locale) + " " + B.getUTCDate();
            break;
        case SimileAjax.DateTime.MONTH:
            var A = B.getUTCMonth();
            if (A != 0) {
                C = Timeline.GregorianDateLabeller.getMonthName(A, this._locale);
                break;
            }
        case SimileAjax.DateTime.YEAR:
        case SimileAjax.DateTime.DECADE:
        case SimileAjax.DateTime.CENTURY:
        case SimileAjax.DateTime.MILLENNIUM:
            var D = B.getUTCFullYear();
            if (D > 0) {
                C = B.getUTCFullYear();
            } else {
                C = (1 - D) + "BC";
            }
            E = (F == SimileAjax.DateTime.MONTH) || (F == SimileAjax.DateTime.DECADE && D % 100 == 0) || (F == SimileAjax.DateTime.CENTURY && D % 1000 == 0);
            break;
        default:
            C = B.toUTCString();
    }
    return {text: C, emphasized: E};
};


/* original-painter.js */
Timeline.OriginalEventPainter = function (A) {
    this._params = A;
    this._onSelectListeners = [];
    this._eventPaintListeners = [];
    this._filterMatcher = null;
    this._highlightMatcher = null;
    this._frc = null;
    this._eventIdToElmt = {};
};
Timeline.OriginalEventPainter.prototype.initialize = function (B, A) {
    this._band = B;
    this._timeline = A;
    this._backLayer = null;
    this._eventLayer = null;
    this._lineLayer = null;
    this._highlightLayer = null;
    this._eventIdToElmt = null;
};
Timeline.OriginalEventPainter.prototype.getType = function () {
    return "original";
};
Timeline.OriginalEventPainter.prototype.addOnSelectListener = function (A) {
    this._onSelectListeners.push(A);
};
Timeline.OriginalEventPainter.prototype.removeOnSelectListener = function (B) {
    for (var A = 0;
         A < this._onSelectListeners.length;
         A++) {
        if (this._onSelectListeners[A] == B) {
            this._onSelectListeners.splice(A, 1);
            break;
        }
    }
};
Timeline.OriginalEventPainter.prototype.addEventPaintListener = function (A) {
    this._eventPaintListeners.push(A);
};
Timeline.OriginalEventPainter.prototype.removeEventPaintListener = function (B) {
    for (var A = 0;
         A < this._eventPaintListeners.length;
         A++) {
        if (this._eventPaintListeners[A] == B) {
            this._eventPaintListeners.splice(A, 1);
            break;
        }
    }
};
Timeline.OriginalEventPainter.prototype.getFilterMatcher = function () {
    return this._filterMatcher;
};
Timeline.OriginalEventPainter.prototype.setFilterMatcher = function (A) {
    this._filterMatcher = A;
};
Timeline.OriginalEventPainter.prototype.getHighlightMatcher = function () {
    return this._highlightMatcher;
};
Timeline.OriginalEventPainter.prototype.setHighlightMatcher = function (A) {
    this._highlightMatcher = A;
};
Timeline.OriginalEventPainter.prototype.paint = function () {
    var B = this._band.getEventSource();
    if (B == null) {
        return;
    }
    this._eventIdToElmt = {};
    this._fireEventPaintListeners("paintStarting", null, null);
    this._prepareForPainting();
    var I = this._params.theme.event;
    var G = Math.max(I.track.height, I.tape.height + this._frc.getLineHeight());
    var F = {
        trackOffset: I.track.offset,
        trackHeight: G,
        trackGap: I.track.gap,
        trackIncrement: G + I.track.gap,
        icon: I.instant.icon,
        iconWidth: I.instant.iconWidth,
        iconHeight: I.instant.iconHeight,
        labelWidth: I.label.width,
        maxLabelChar: I.label.maxLabelChar,
        impreciseIconMargin: I.instant.impreciseIconMargin
    };
    var C = this._band.getMinDate();
    var A = this._band.getMaxDate();
    var J = (this._filterMatcher != null) ? this._filterMatcher : function (K) {
        return true;
    };
    var E = (this._highlightMatcher != null) ? this._highlightMatcher : function (K) {
        return -1;
    };
    var D = B.getEventReverseIterator(C, A);
    while (D.hasNext()) {
        var H = D.next();
        if (J(H)) {
            this.paintEvent(H, F, this._params.theme, E(H));
        }
    }
    this._highlightLayer.style.display = "block";
    this._lineLayer.style.display = "block";
    this._eventLayer.style.display = "block";
    this._band.updateEventTrackInfo(this._tracks.length, F.trackIncrement);
    this._fireEventPaintListeners("paintEnded", null, null);
};
Timeline.OriginalEventPainter.prototype.softPaint = function () {
};
Timeline.OriginalEventPainter.prototype._prepareForPainting = function () {
    var B = this._band;
    if (this._backLayer == null) {
        this._backLayer = this._band.createLayerDiv(0, "timeline-band-events");
        this._backLayer.style.visibility = "hidden";
        var A = document.createElement("span");
        A.className = "timeline-event-label";
        this._backLayer.appendChild(A);
        this._frc = SimileAjax.Graphics.getFontRenderingContext(A);
    }
    this._frc.update();
    this._tracks = [];
    if (this._highlightLayer != null) {
        B.removeLayerDiv(this._highlightLayer);
    }
    this._highlightLayer = B.createLayerDiv(105, "timeline-band-highlights");
    this._highlightLayer.style.display = "none";
    if (this._lineLayer != null) {
        B.removeLayerDiv(this._lineLayer);
    }
    this._lineLayer = B.createLayerDiv(110, "timeline-band-lines");
    this._lineLayer.style.display = "none";
    if (this._eventLayer != null) {
        B.removeLayerDiv(this._eventLayer);
    }
    this._eventLayer = B.createLayerDiv(115, "timeline-band-events");
    this._eventLayer.style.display = "none";
};
Timeline.OriginalEventPainter.prototype.paintEvent = function (B, C, D, A) {
    if (B.isInstant()) {
        this.paintInstantEvent(B, C, D, A);
    } else {
        this.paintDurationEvent(B, C, D, A);
    }
};
Timeline.OriginalEventPainter.prototype.paintInstantEvent = function (B, C, D, A) {
    if (B.isImprecise()) {
        this.paintImpreciseInstantEvent(B, C, D, A);
    } else {
        this.paintPreciseInstantEvent(B, C, D, A);
    }
};
Timeline.OriginalEventPainter.prototype.paintDurationEvent = function (B, C, D, A) {
    if (B.isImprecise()) {
        this.paintImpreciseDurationEvent(B, C, D, A);
    } else {
        this.paintPreciseDurationEvent(B, C, D, A);
    }
};
Timeline.OriginalEventPainter.prototype.paintPreciseInstantEvent = function (M, Q, S, R) {
    var V = this._timeline.getDocument();
    var L = M.getText();
    var E = M.getStart();
    var C = Math.round(this._band.dateToPixelOffset(E));
    var A = Math.round(C + Q.iconWidth / 2);
    var K = Math.round(C - Q.iconWidth / 2);
    var H = this._getLabelDivClassName(M);
    var I = this._frc.computeSize(L, H);
    var W = A + S.event.label.offsetFromLine;
    var D = W + I.width;
    var U = D;
    var O = this._findFreeTrack(M, U);
    var T = Math.round(Q.trackOffset + O * Q.trackIncrement + Q.trackHeight / 2 - I.height / 2);
    var B = this._paintEventIcon(M, O, K, Q, S, 0);
    var P = this._paintEventLabel(M, L, W, T, I.width, I.height, S, H, R);
    var F = [B.elmt, P.elmt];
    var N = this;
    var J = function (X, Y, Z) {
        return N._onClickInstantEvent(B.elmt, Y, M);
    };
    SimileAjax.DOM.registerEvent(B.elmt, "mousedown", J);
    SimileAjax.DOM.registerEvent(P.elmt, "mousedown", J);
    var G = this._createHighlightDiv(R, B, S, M);
    if (G != null) {
        F.push(G);
    }
    this._fireEventPaintListeners("paintedEvent", M, F);
    this._eventIdToElmt[M.getID()] = B.elmt;
    this._tracks[O] = K;
};
Timeline.OriginalEventPainter.prototype.paintImpreciseInstantEvent = function (P, T, Y, V) {
    var a = this._timeline.getDocument();
    var N = P.getText();
    var G = P.getStart();
    var W = P.getEnd();
    var D = Math.round(this._band.dateToPixelOffset(G));
    var B = Math.round(this._band.dateToPixelOffset(W));
    var A = Math.round(D + T.iconWidth / 2);
    var M = Math.round(D - T.iconWidth / 2);
    var J = this._getLabelDivClassName(P);
    var K = this._frc.computeSize(N, J);
    var b = A + Y.event.label.offsetFromLine;
    var E = b + K.width;
    var Z = Math.max(E, B);
    var R = this._findFreeTrack(P, Z);
    var O = Y.event.tape.height;
    var X = Math.round(T.trackOffset + R * T.trackIncrement + O);
    var C = this._paintEventIcon(P, R, M, T, Y, O);
    var S = this._paintEventLabel(P, N, b, X, K.width, K.height, Y, J, V);
    var U = P.getColor();
    U = U != null ? U : Y.event.instant.impreciseColor;
    var F = this._paintEventTape(P, R, D, B, U, Y.event.instant.impreciseOpacity, T, Y, 0);
    var H = [C.elmt, S.elmt, F.elmt];
    var Q = this;
    var L = function (c, d, e) {
        return Q._onClickInstantEvent(C.elmt, d, P);
    };
    SimileAjax.DOM.registerEvent(C.elmt, "mousedown", L);
    SimileAjax.DOM.registerEvent(F.elmt, "mousedown", L);
    SimileAjax.DOM.registerEvent(S.elmt, "mousedown", L);
    var I = this._createHighlightDiv(V, C, Y, P);
    if (I != null) {
        H.push(I);
    }
    this._fireEventPaintListeners("paintedEvent", P, H);
    this._eventIdToElmt[P.getID()] = C.elmt;
    this._tracks[R] = M;
};
Timeline.OriginalEventPainter.prototype.paintPreciseDurationEvent = function (L, P, T, R) {
    var W = this._timeline.getDocument();
    var K = L.getText();
    var E = L.getStart();
    var S = L.getEnd();
    var B = Math.round(this._band.dateToPixelOffset(E));
    var A = Math.round(this._band.dateToPixelOffset(S));
    var H = this._getLabelDivClassName(L);
    var I = this._frc.computeSize(K, H);
    var X = B;
    var C = X + I.width;
    var V = Math.max(C, A);
    var N = this._findFreeTrack(L, V);
    var U = Math.round(P.trackOffset + N * P.trackIncrement + T.event.tape.height);
    var Q = L.getColor();
    Q = Q != null ? Q : T.event.duration.color;
    var D = this._paintEventTape(L, N, B, A, Q, 100, P, T, 0);
    var O = this._paintEventLabel(L, K, X, U, I.width, I.height, T, H, R);
    var F = [D.elmt, O.elmt];
    var M = this;
    var J = function (Y, Z, a) {
        return M._onClickDurationEvent(D.elmt, Z, L);
    };
    SimileAjax.DOM.registerEvent(D.elmt, "mousedown", J);
    SimileAjax.DOM.registerEvent(O.elmt, "mousedown", J);
    var G = this._createHighlightDiv(R, D, T, L);
    if (G != null) {
        F.push(G);
    }
    this._fireEventPaintListeners("paintedEvent", L, F);
    this._eventIdToElmt[L.getID()] = D.elmt;
    this._tracks[N] = B;
};
Timeline.OriginalEventPainter.prototype.paintImpreciseDurationEvent = function (N, S, Y, V) {
    var b = this._timeline.getDocument();
    var M = N.getText();
    var E = N.getStart();
    var T = N.getLatestStart();
    var W = N.getEnd();
    var a = N.getEarliestEnd();
    var C = Math.round(this._band.dateToPixelOffset(E));
    var G = Math.round(this._band.dateToPixelOffset(T));
    var A = Math.round(this._band.dateToPixelOffset(W));
    var H = Math.round(this._band.dateToPixelOffset(a));
    var J = this._getLabelDivClassName(N);
    var K = this._frc.computeSize(M, J);
    var c = G;
    var B = c + K.width;
    var Z = Math.max(B, A);
    var P = this._findFreeTrack(N, Z);
    var X = Math.round(S.trackOffset + P * S.trackIncrement + Y.event.tape.height);
    var U = N.getColor();
    U = U != null ? U : Y.event.duration.color;
    var R = this._paintEventTape(N, P, C, A, Y.event.duration.impreciseColor, Y.event.duration.impreciseOpacity, S, Y, 0);
    var D = this._paintEventTape(N, P, G, H, U, 100, S, Y, 1);
    var Q = this._paintEventLabel(N, M, c, X, K.width, K.height, Y, J, V);
    var F = [R.elmt, D.elmt, Q.elmt];
    var O = this;
    var L = function (d, e, f) {
        return O._onClickDurationEvent(D.elmt, e, N);
    };
    SimileAjax.DOM.registerEvent(D.elmt, "mousedown", L);
    SimileAjax.DOM.registerEvent(Q.elmt, "mousedown", L);
    var I = this._createHighlightDiv(V, D, Y, N);
    if (I != null) {
        F.push(I);
    }
    this._fireEventPaintListeners("paintedEvent", N, F);
    this._eventIdToElmt[N.getID()] = D.elmt;
    this._tracks[P] = C;
};
Timeline.OriginalEventPainter.prototype._encodeEventElID = function (B, A) {
    return Timeline.EventUtils.encodeEventElID(this._timeline, this._band, B, A);
};
Timeline.OriginalEventPainter.prototype._findFreeTrack = function (E, A) {
    var D = E.getTrackNum();
    if (D != null) {
        return D;
    }
    for (var C = 0;
         C < this._tracks.length;
         C++) {
        var B = this._tracks[C];
        if (B > A) {
            break;
        }
    }
    return C;
};
Timeline.OriginalEventPainter.prototype._paintEventIcon = function (J, F, B, G, E, C) {
    var I = J.getIcon();
    I = I != null ? I : G.icon;
    var H;
    if (C > 0) {
        H = G.trackOffset + F * G.trackIncrement + C + G.impreciseIconMargin;
    } else {
        var K = G.trackOffset + F * G.trackIncrement + G.trackHeight / 2;
        H = Math.round(K - G.iconHeight / 2);
    }
    var D = SimileAjax.Graphics.createTranslucentImage(I);
    var A = this._timeline.getDocument().createElement("div");
    A.className = this._getElClassName("timeline-event-icon", J, "icon");
    A.id = this._encodeEventElID("icon", J);
    A.style.left = B + "px";
    A.style.top = H + "px";
    A.appendChild(D);
    if (J._title != null) {
        A.title = J._title;
    }
    this._eventLayer.appendChild(A);
    return {left: B, top: H, width: G.iconWidth, height: G.iconHeight, elmt: A};
};
Timeline.OriginalEventPainter.prototype._paintEventLabel = function (J, K, C, H, A, L, E, F, B) {
    var I = this._timeline.getDocument();
    var G = I.createElement("div");
    G.className = F;
    G.id = this._encodeEventElID("label", J);
    G.style.left = C + "px";
    G.style.width = A + "px";
    G.style.top = H + "px";
    G.innerHTML = K;
    if (J._title != null) {
        G.title = J._title;
    }
    var D = J.getTextColor();
    if (D == null) {
        D = J.getColor();
    }
    if (D != null) {
        G.style.color = D;
    }
    if (E.event.highlightLabelBackground && B >= 0) {
        G.style.background = this._getHighlightColor(B, E);
    }
    this._eventLayer.appendChild(G);
    return {left: C, top: H, width: A, height: L, elmt: G};
};
Timeline.OriginalEventPainter.prototype._paintEventTape = function (N, I, F, A, C, H, J, G, O) {
    var B = A - F;
    var E = G.event.tape.height;
    var K = J.trackOffset + I * J.trackIncrement;
    var M = this._timeline.getDocument().createElement("div");
    M.className = this._getElClassName("timeline-event-tape", N, "tape");
    M.id = this._encodeEventElID("tape" + O, N);
    M.style.left = F + "px";
    M.style.width = B + "px";
    M.style.height = E + "px";
    M.style.top = K + "px";
    if (N._title != null) {
        M.title = N._title;
    }
    if (C != null) {
        M.style.backgroundColor = C;
    }
    var L = N.getTapeImage();
    var D = N.getTapeRepeat();
    D = D != null ? D : "repeat";
    if (L != null) {
        M.style.backgroundImage = "url(" + L + ")";
        M.style.backgroundRepeat = D;
    }
    SimileAjax.Graphics.setOpacity(M, H);
    this._eventLayer.appendChild(M);
    return {left: F, top: K, width: B, height: E, elmt: M};
};
Timeline.OriginalEventPainter.prototype._getLabelDivClassName = function (A) {
    return this._getElClassName("timeline-event-label", A, "label");
};
Timeline.OriginalEventPainter.prototype._getElClassName = function (B, A, D) {
    var E = A.getClassName(), C = [];
    if (E) {
        if (D) {
            C.push(D + "-" + E + " ");
        }
        C.push(E + " ");
    }
    C.push(B);
    return (C.join(""));
};
Timeline.OriginalEventPainter.prototype._getHighlightColor = function (A, C) {
    var B = C.event.highlightColors;
    return B[Math.min(A, B.length - 1)];
};
Timeline.OriginalEventPainter.prototype._createHighlightDiv = function (A, D, F, B) {
    var G = null;
    if (A >= 0) {
        var E = this._timeline.getDocument();
        var C = this._getHighlightColor(A, F);
        G = E.createElement("div");
        G.className = this._getElClassName("timeline-event-highlight", B, "highlight");
        G.id = this._encodeEventElID("highlight0", B);
        G.style.position = "absolute";
        G.style.overflow = "hidden";
        G.style.left = (D.left - 2) + "px";
        G.style.width = (D.width + 4) + "px";
        G.style.top = (D.top - 2) + "px";
        G.style.height = (D.height + 4) + "px";
        G.style.background = C;
        this._highlightLayer.appendChild(G);
    }
    return G;
};
Timeline.OriginalEventPainter.prototype._onClickInstantEvent = function (B, C, A) {
    var D = SimileAjax.DOM.getPageCoordinates(B);
    this._showBubble(D.left + Math.ceil(B.offsetWidth / 2), D.top + Math.ceil(B.offsetHeight / 2), A);
    this._fireOnSelect(A.getID());
    C.cancelBubble = true;
    SimileAjax.DOM.cancelEvent(C);
    return false;
};
Timeline.OriginalEventPainter.prototype._onClickDurationEvent = function (D, C, B) {
    if ("pageX" in C) {
        var A = C.pageX;
        var F = C.pageY;
    } else {
        var E = SimileAjax.DOM.getPageCoordinates(D);
        var A = C.offsetX + E.left;
        var F = C.offsetY + E.top;
    }
    this._showBubble(A, F, B);
    this._fireOnSelect(B.getID());
    C.cancelBubble = true;
    SimileAjax.DOM.cancelEvent(C);
    return false;
};
Timeline.OriginalEventPainter.prototype.showBubble = function (A) {
    var B = this._eventIdToElmt[A.getID()];
    if (B) {
        var C = SimileAjax.DOM.getPageCoordinates(B);
        this._showBubble(C.left + B.offsetWidth / 2, C.top + B.offsetHeight / 2, A);
    }
};
Timeline.OriginalEventPainter.prototype._showBubble = function (A, E, B) {
    var D = document.createElement("div");
    var C = this._params.theme.event.bubble;
    B.fillInfoBubble(D, this._params.theme, this._band.getLabeller());
    SimileAjax.WindowManager.cancelPopups();
    SimileAjax.Graphics.createBubbleForContentAndPoint(D, A, E, C.width, null, C.maxHeight);
};
Timeline.OriginalEventPainter.prototype._fireOnSelect = function (B) {
    for (var A = 0;
         A < this._onSelectListeners.length;
         A++) {
        this._onSelectListeners[A](B);
    }
};
Timeline.OriginalEventPainter.prototype._fireEventPaintListeners = function (D, A, C) {
    for (var B = 0;
         B < this._eventPaintListeners.length;
         B++) {
        this._eventPaintListeners[B](this._band, D, A, C);
    }
};


/* overview-painter.js */
Timeline.OverviewEventPainter = function (A) {
    this._params = A;
    this._onSelectListeners = [];
    this._filterMatcher = null;
    this._highlightMatcher = null;
};
Timeline.OverviewEventPainter.prototype.initialize = function (B, A) {
    this._band = B;
    this._timeline = A;
    this._eventLayer = null;
    this._highlightLayer = null;
};
Timeline.OverviewEventPainter.prototype.getType = function () {
    return "overview";
};
Timeline.OverviewEventPainter.prototype.addOnSelectListener = function (A) {
    this._onSelectListeners.push(A);
};
Timeline.OverviewEventPainter.prototype.removeOnSelectListener = function (B) {
    for (var A = 0;
         A < this._onSelectListeners.length;
         A++) {
        if (this._onSelectListeners[A] == B) {
            this._onSelectListeners.splice(A, 1);
            break;
        }
    }
};
Timeline.OverviewEventPainter.prototype.getFilterMatcher = function () {
    return this._filterMatcher;
};
Timeline.OverviewEventPainter.prototype.setFilterMatcher = function (A) {
    this._filterMatcher = A;
};
Timeline.OverviewEventPainter.prototype.getHighlightMatcher = function () {
    return this._highlightMatcher;
};
Timeline.OverviewEventPainter.prototype.setHighlightMatcher = function (A) {
    this._highlightMatcher = A;
};
Timeline.OverviewEventPainter.prototype.paint = function () {
    var B = this._band.getEventSource();
    if (B == null) {
        return;
    }
    this._prepareForPainting();
    var H = this._params.theme.event;
    var F = {trackOffset: H.overviewTrack.offset, trackHeight: H.overviewTrack.height, trackGap: H.overviewTrack.gap, trackIncrement: H.overviewTrack.height + H.overviewTrack.gap};
    var C = this._band.getMinDate();
    var A = this._band.getMaxDate();
    var I = (this._filterMatcher != null) ? this._filterMatcher : function (J) {
        return true;
    };
    var E = (this._highlightMatcher != null) ? this._highlightMatcher : function (J) {
        return -1;
    };
    var D = B.getEventReverseIterator(C, A);
    while (D.hasNext()) {
        var G = D.next();
        if (I(G)) {
            this.paintEvent(G, F, this._params.theme, E(G));
        }
    }
    this._highlightLayer.style.display = "block";
    this._eventLayer.style.display = "block";
    this._band.updateEventTrackInfo(this._tracks.length, F.trackIncrement);
};
Timeline.OverviewEventPainter.prototype.softPaint = function () {
};
Timeline.OverviewEventPainter.prototype._prepareForPainting = function () {
    var A = this._band;
    this._tracks = [];
    if (this._highlightLayer != null) {
        A.removeLayerDiv(this._highlightLayer);
    }
    this._highlightLayer = A.createLayerDiv(105, "timeline-band-highlights");
    this._highlightLayer.style.display = "none";
    if (this._eventLayer != null) {
        A.removeLayerDiv(this._eventLayer);
    }
    this._eventLayer = A.createLayerDiv(110, "timeline-band-events");
    this._eventLayer.style.display = "none";
};
Timeline.OverviewEventPainter.prototype.paintEvent = function (B, C, D, A) {
    if (B.isInstant()) {
        this.paintInstantEvent(B, C, D, A);
    } else {
        this.paintDurationEvent(B, C, D, A);
    }
};
Timeline.OverviewEventPainter.prototype.paintInstantEvent = function (I, H, F, A) {
    var B = I.getStart();
    var E = Math.round(this._band.dateToPixelOffset(B));
    var D = I.getColor(), C = I.getClassName();
    if (C) {
        D = null;
    } else {
        D = D != null ? D : F.event.duration.color;
    }
    var G = this._paintEventTick(I, E, D, 100, H, F);
    this._createHighlightDiv(A, G, F);
};
Timeline.OverviewEventPainter.prototype.paintDurationEvent = function (L, K, J, D) {
    var A = L.getLatestStart();
    var C = L.getEarliestEnd();
    var B = Math.round(this._band.dateToPixelOffset(A));
    var E = Math.round(this._band.dateToPixelOffset(C));
    var I = 0;
    for (;
        I < this._tracks.length;
        I++) {
        if (E < this._tracks[I]) {
            break;
        }
    }
    this._tracks[I] = E;
    var H = L.getColor(), G = L.getClassName();
    if (G) {
        H = null;
    } else {
        H = H != null ? H : J.event.duration.color;
    }
    var F = this._paintEventTape(L, I, B, E, H, 100, K, J, G);
    this._createHighlightDiv(D, F, J);
};
Timeline.OverviewEventPainter.prototype._paintEventTape = function (L, B, C, K, E, G, H, F, D) {
    var I = H.trackOffset + B * H.trackIncrement;
    var A = K - C;
    var M = H.trackHeight;
    var J = this._timeline.getDocument().createElement("div");
    J.className = "timeline-small-event-tape";
    if (D) {
        J.className += " small-" + D;
    }
    J.style.left = C + "px";
    J.style.width = A + "px";
    J.style.top = I + "px";
    J.style.height = M + "px";
    if (E) {
        J.style.backgroundColor = E;
    }
    if (G < 100) {
        SimileAjax.Graphics.setOpacity(J, G);
    }
    this._eventLayer.appendChild(J);
    return {left: C, top: I, width: A, height: M, elmt: J};
};
Timeline.OverviewEventPainter.prototype._paintEventTick = function (J, B, D, F, G, E) {
    var K = E.event.overviewTrack.tickHeight;
    var H = G.trackOffset - K;
    var A = 1;
    var I = this._timeline.getDocument().createElement("div");
    I.className = "timeline-small-event-icon";
    I.style.left = B + "px";
    I.style.top = H + "px";
    var C = J.getClassName();
    if (C) {
        I.className += " small-" + C;
    }
    if (F < 100) {
        SimileAjax.Graphics.setOpacity(I, F);
    }
    this._eventLayer.appendChild(I);
    return {left: B, top: H, width: A, height: K, elmt: I};
};
Timeline.OverviewEventPainter.prototype._createHighlightDiv = function (A, C, E) {
    if (A >= 0) {
        var D = this._timeline.getDocument();
        var G = E.event;
        var B = G.highlightColors[Math.min(A, G.highlightColors.length - 1)];
        var F = D.createElement("div");
        F.style.position = "absolute";
        F.style.overflow = "hidden";
        F.style.left = (C.left - 1) + "px";
        F.style.width = (C.width + 2) + "px";
        F.style.top = (C.top - 1) + "px";
        F.style.height = (C.height + 2) + "px";
        F.style.background = B;
        this._highlightLayer.appendChild(F);
    }
};
Timeline.OverviewEventPainter.prototype.showBubble = function (A) {
};


/* sources.js */
Timeline.DefaultEventSource = function (A) {
    this._events = (A instanceof Object) ? A : new SimileAjax.EventIndex();
    this._listeners = [];
};
Timeline.DefaultEventSource.prototype.addListener = function (A) {
    this._listeners.push(A);
};
Timeline.DefaultEventSource.prototype.removeListener = function (B) {
    for (var A = 0;
         A < this._listeners.length;
         A++) {
        if (this._listeners[A] == B) {
            this._listeners.splice(A, 1);
            break;
        }
    }
};
Timeline.DefaultEventSource.prototype.loadXML = function (G, A) {
    var C = this._getBaseURL(A);
    var H = G.documentElement.getAttribute("wiki-url");
    var L = G.documentElement.getAttribute("wiki-section");
    var E = G.documentElement.getAttribute("date-time-format");
    var F = this._events.getUnit().getParser(E);
    var D = G.documentElement.firstChild;
    var I = false;
    while (D != null) {
        if (D.nodeType == 1) {
            var K = "";
            if (D.firstChild != null && D.firstChild.nodeType == 3) {
                K = D.firstChild.nodeValue;
            }
            var B = (D.getAttribute("isDuration") === null && D.getAttribute("durationEvent") === null) || D.getAttribute("isDuration") == "false" || D.getAttribute("durationEvent") == "false";
            var J = new Timeline.DefaultEventSource.Event({
                id: D.getAttribute("id"),
                start: F(D.getAttribute("start")),
                end: F(D.getAttribute("end")),
                latestStart: F(D.getAttribute("latestStart")),
                earliestEnd: F(D.getAttribute("earliestEnd")),
                instant: B,
                text: D.getAttribute("title"),
                description: K,
                image: this._resolveRelativeURL(D.getAttribute("image"), C),
                link: this._resolveRelativeURL(D.getAttribute("link"), C),
                icon: this._resolveRelativeURL(D.getAttribute("icon"), C),
                color: D.getAttribute("color"),
                textColor: D.getAttribute("textColor"),
                hoverText: D.getAttribute("hoverText"),
                classname: D.getAttribute("classname"),
                tapeImage: D.getAttribute("tapeImage"),
                tapeRepeat: D.getAttribute("tapeRepeat"),
                caption: D.getAttribute("caption"),
                eventID: D.getAttribute("eventID"),
                trackNum: D.getAttribute("trackNum")
            });
            J._node = D;
            J.getProperty = function (M) {
                return this._node.getAttribute(M);
            };
            J.setWikiInfo(H, L);
            this._events.add(J);
            I = true;
        }
        D = D.nextSibling;
    }
    if (I) {
        this._fire("onAddMany", []);
    }
};
Timeline.DefaultEventSource.prototype.loadJSON = function (G, B) {
    var D = this._getBaseURL(B);
    var J = false;
    if (G && G.events) {
        var I = ("wikiURL" in G) ? G.wikiURL : null;
        var L = ("wikiSection" in G) ? G.wikiSection : null;
        var E = ("dateTimeFormat" in G) ? G.dateTimeFormat : null;
        var H = this._events.getUnit().getParser(E);
        for (var F = 0;
             F < G.events.length;
             F++) {
            var A = G.events[F];
            var C = A.isDuration || (A.durationEvent != null && !A.durationEvent);
            var K = new Timeline.DefaultEventSource.Event({
                id: ("id" in A) ? A.id : undefined,
                start: H(A.start),
                end: H(A.end),
                latestStart: H(A.latestStart),
                earliestEnd: H(A.earliestEnd),
                instant: C,
                text: A.title,
                description: A.description,
                image: this._resolveRelativeURL(A.image, D),
                link: this._resolveRelativeURL(A.link, D),
                icon: this._resolveRelativeURL(A.icon, D),
                color: A.color,
                textColor: A.textColor,
                hoverText: A.hoverText,
                classname: A.classname,
                tapeImage: A.tapeImage,
                tapeRepeat: A.tapeRepeat,
                caption: A.caption,
                eventID: A.eventID,
                trackNum: A.trackNum
            });
            K._obj = A;
            K.getProperty = function (M) {
                return this._obj[M];
            };
            K.setWikiInfo(I, L);
            this._events.add(K);
            J = true;
        }
    }
    if (J) {
        this._fire("onAddMany", []);
    }
};
Timeline.DefaultEventSource.prototype.loadSPARQL = function (H, A) {
    var D = this._getBaseURL(A);
    var F = "iso8601";
    var G = this._events.getUnit().getParser(F);
    if (H == null) {
        return;
    }
    var E = H.documentElement.firstChild;
    while (E != null && (E.nodeType != 1 || E.nodeName != "results")) {
        E = E.nextSibling;
    }
    var J = null;
    var M = null;
    if (E != null) {
        J = E.getAttribute("wiki-url");
        M = E.getAttribute("wiki-section");
        E = E.firstChild;
    }
    var K = false;
    while (E != null) {
        if (E.nodeType == 1) {
            var C = {};
            var I = E.firstChild;
            while (I != null) {
                if (I.nodeType == 1 && I.firstChild != null && I.firstChild.nodeType == 1 && I.firstChild.firstChild != null && I.firstChild.firstChild.nodeType == 3) {
                    C[I.getAttribute("name")] = I.firstChild.firstChild.nodeValue;
                }
                I = I.nextSibling;
            }
            if (C["start"] == null && C["date"] != null) {
                C["start"] = C["date"];
            }
            var B = (C["isDuration"] === null && C["durationEvent"] === null) || C["isDuration"] == "false" || C["durationEvent"] == "false";
            var L = new Timeline.DefaultEventSource.Event({
                id: C["id"],
                start: G(C["start"]),
                end: G(C["end"]),
                latestStart: G(C["latestStart"]),
                earliestEnd: G(C["earliestEnd"]),
                instant: B,
                text: C["title"],
                description: C["description"],
                image: this._resolveRelativeURL(C["image"], D),
                link: this._resolveRelativeURL(C["link"], D),
                icon: this._resolveRelativeURL(C["icon"], D),
                color: C["color"],
                textColor: C["textColor"],
                hoverText: C["hoverText"],
                caption: C["caption"],
                classname: C["classname"],
                tapeImage: C["tapeImage"],
                tapeRepeat: C["tapeRepeat"],
                eventID: C["eventID"],
                trackNum: C["trackNum"]
            });
            L._bindings = C;
            L.getProperty = function (N) {
                return this._bindings[N];
            };
            L.setWikiInfo(J, M);
            this._events.add(L);
            K = true;
        }
        E = E.nextSibling;
    }
    if (K) {
        this._fire("onAddMany", []);
    }
};
Timeline.DefaultEventSource.prototype.add = function (A) {
    this._events.add(A);
    this._fire("onAddOne", [A]);
};
Timeline.DefaultEventSource.prototype.addMany = function (B) {
    for (var A = 0;
         A < B.length;
         A++) {
        this._events.add(B[A]);
    }
    this._fire("onAddMany", []);
};
Timeline.DefaultEventSource.prototype.clear = function () {
    this._events.removeAll();
    this._fire("onClear", []);
};
Timeline.DefaultEventSource.prototype.getEvent = function (A) {
    return this._events.getEvent(A);
};
Timeline.DefaultEventSource.prototype.getEventIterator = function (A, B) {
    return this._events.getIterator(A, B);
};
Timeline.DefaultEventSource.prototype.getEventReverseIterator = function (A, B) {
    return this._events.getReverseIterator(A, B);
};
Timeline.DefaultEventSource.prototype.getAllEventIterator = function () {
    return this._events.getAllIterator();
};
Timeline.DefaultEventSource.prototype.getCount = function () {
    return this._events.getCount();
};
Timeline.DefaultEventSource.prototype.getEarliestDate = function () {
    return this._events.getEarliestDate();
};
Timeline.DefaultEventSource.prototype.getLatestDate = function () {
    return this._events.getLatestDate();
};
Timeline.DefaultEventSource.prototype._fire = function (B, A) {
    for (var C = 0;
         C < this._listeners.length;
         C++) {
        var D = this._listeners[C];
        if (B in D) {
            try {
                D[B].apply(D, A);
            } catch (E) {
                SimileAjax.Debug.exception(E);
            }
        }
    }
};
Timeline.DefaultEventSource.prototype._getBaseURL = function (A) {
    if (A.indexOf("://") < 0) {
        var C = this._getBaseURL(document.location.href);
        if (A.substr(0, 1) == "/") {
            A = C.substr(0, C.indexOf("/", C.indexOf("://") + 3)) + A;
        } else {
            A = C + A;
        }
    }
    var B = A.lastIndexOf("/");
    if (B < 0) {
        return "";
    } else {
        return A.substr(0, B + 1);
    }
};
Timeline.DefaultEventSource.prototype._resolveRelativeURL = function (A, B) {
    if (A == null || A == "") {
        return A;
    } else {
        if (A.indexOf("://") > 0) {
            return A;
        } else {
            if (A.substr(0, 1) == "/") {
                return B.substr(0, B.indexOf("/", B.indexOf("://") + 3)) + A;
            } else {
                return B + A;
            }
        }
    }
};
Timeline.DefaultEventSource.Event = function (A) {
    function D(E) {
        return (A[E] != null && A[E] != "") ? A[E] : null;
    }

    var C = A.id ? A.id.trim() : "";
    this._id = C.length > 0 ? C : Timeline.EventUtils.getNewEventID();
    this._instant = A.instant || (A.end == null);
    this._start = A.start;
    this._end = (A.end != null) ? A.end : A.start;
    this._latestStart = (A.latestStart != null) ? A.latestStart : (A.instant ? this._end : this._start);
    this._earliestEnd = (A.earliestEnd != null) ? A.earliestEnd : this._end;
    var B = [];
    if (this._start > this._latestStart) {
        this._latestStart = this._start;
        B.push("start is > latestStart");
    }
    if (this._start > this._earliestEnd) {
        this._earliestEnd = this._latestStart;
        B.push("start is > earliestEnd");
    }
    if (this._start > this._end) {
        this._end = this._earliestEnd;
        B.push("start is > end");
    }
    if (this._latestStart > this._earliestEnd) {
        this._earliestEnd = this._latestStart;
        B.push("latestStart is > earliestEnd");
    }
    if (this._latestStart > this._end) {
        this._end = this._earliestEnd;
        B.push("latestStart is > end");
    }
    if (this._earliestEnd > this._end) {
        this._end = this._earliestEnd;
        B.push("earliestEnd is > end");
    }
    this._eventID = D("eventID");
    this._text = (A.text != null) ? SimileAjax.HTML.deEntify(A.text) : "";
    if (B.length > 0) {
        this._text += " PROBLEM: " + B.join(", ");
    }
    this._description = SimileAjax.HTML.deEntify(A.description);
    this._image = D("image");
    this._link = D("link");
    this._title = D("hoverText");
    this._title = D("caption");
    this._icon = D("icon");
    this._color = D("color");
    this._textColor = D("textColor");
    this._classname = D("classname");
    this._tapeImage = D("tapeImage");
    this._tapeRepeat = D("tapeRepeat");
    this._trackNum = D("trackNum");
    if (this._trackNum != null) {
        this._trackNum = parseInt(this._trackNum);
    }
    this._wikiURL = null;
    this._wikiSection = null;
};
Timeline.DefaultEventSource.Event.prototype = {
    getID: function () {
        return this._id;
    }, isInstant: function () {
        return this._instant;
    }, isImprecise: function () {
        return this._start != this._latestStart || this._end != this._earliestEnd;
    }, getStart: function () {
        return this._start;
    }, getEnd: function () {
        return this._end;
    }, getLatestStart: function () {
        return this._latestStart;
    }, getEarliestEnd: function () {
        return this._earliestEnd;
    }, getEventID: function () {
        return this._eventID;
    }, getText: function () {
        return this._text;
    }, getDescription: function () {
        return this._description;
    }, getImage: function () {
        return this._image;
    }, getLink: function () {
        return this._link;
    }, getIcon: function () {
        return this._icon;
    }, getColor: function () {
        return this._color;
    }, getTextColor: function () {
        return this._textColor;
    }, getClassName: function () {
        return this._classname;
    }, getTapeImage: function () {
        return this._tapeImage;
    }, getTapeRepeat: function () {
        return this._tapeRepeat;
    }, getTrackNum: function () {
        return this._trackNum;
    }, getProperty: function (A) {
        return null;
    }, getWikiURL: function () {
        return this._wikiURL;
    }, getWikiSection: function () {
        return this._wikiSection;
    }, setWikiInfo: function (B, A) {
        this._wikiURL = B;
        this._wikiSection = A;
    }, fillDescription: function (A) {
        A.innerHTML = this._description;
    }, fillWikiInfo: function (D) {
        D.style.display = "none";
        if (this._wikiURL == null || this._wikiSection == null) {
            return;
        }
        var C = this.getProperty("wikiID");
        if (C == null || C.length == 0) {
            C = this.getText();
        }
        if (C == null || C.length == 0) {
            return;
        }
        D.style.display = "inline";
        C = C.replace(/\s/g, "_");
        var B = this._wikiURL + this._wikiSection.replace(/\s/g, "_") + "/" + C;
        var A = document.createElement("a");
        A.href = B;
        A.target = "new";
        A.innerHTML = Timeline.strings[Timeline.clientLocale].wikiLinkLabel;
        D.appendChild(document.createTextNode("["));
        D.appendChild(A);
        D.appendChild(document.createTextNode("]"));
    }, fillTime: function (A, B) {
        if (this._instant) {
            if (this.isImprecise()) {
                A.appendChild(A.ownerDocument.createTextNode(B.labelPrecise(this._start)));
                A.appendChild(A.ownerDocument.createElement("br"));
                A.appendChild(A.ownerDocument.createTextNode(B.labelPrecise(this._end)));
            } else {
                A.appendChild(A.ownerDocument.createTextNode(B.labelPrecise(this._start)));
            }
        } else {
            if (this.isImprecise()) {
                A.appendChild(A.ownerDocument.createTextNode(B.labelPrecise(this._start) + " ~ " + B.labelPrecise(this._latestStart)));
                A.appendChild(A.ownerDocument.createElement("br"));
                A.appendChild(A.ownerDocument.createTextNode(B.labelPrecise(this._earliestEnd) + " ~ " + B.labelPrecise(this._end)));
            } else {
                A.appendChild(A.ownerDocument.createTextNode(B.labelPrecise(this._start)));
                A.appendChild(A.ownerDocument.createElement("br"));
                A.appendChild(A.ownerDocument.createTextNode(B.labelPrecise(this._end)));
            }
        }
    }, fillInfoBubble: function (A, D, K) {
        var L = A.ownerDocument;
        var J = this.getText();
        var H = this.getLink();
        var C = this.getImage();
        if (C != null) {
            var E = L.createElement("img");
            E.src = C;
            D.event.bubble.imageStyler(E);
            A.appendChild(E);
        }
        var M = L.createElement("div");
        var B = L.createTextNode(J);
        if (H != null) {
            var I = L.createElement("a");
            I.href = H;
            I.appendChild(B);
            M.appendChild(I);
        } else {
            M.appendChild(B);
        }
        D.event.bubble.titleStyler(M);
        A.appendChild(M);
        var N = L.createElement("div");
        this.fillDescription(N);
        D.event.bubble.bodyStyler(N);
        A.appendChild(N);
        var G = L.createElement("div");
        this.fillTime(G, K);
        D.event.bubble.timeStyler(G);
        A.appendChild(G);
        var F = L.createElement("div");
        this.fillWikiInfo(F);
        D.event.bubble.wikiStyler(F);
        A.appendChild(F);
    }
};


/* themes.js */
Timeline.ClassicTheme = new Object();
Timeline.ClassicTheme.implementations = [];
Timeline.ClassicTheme.create = function (A) {
    if (A == null) {
        A = Timeline.getDefaultLocale();
    }
    var B = Timeline.ClassicTheme.implementations[A];
    if (B == null) {
        B = Timeline.ClassicTheme._Impl;
    }
    return new B();
};
Timeline.ClassicTheme._Impl = function () {
    this.firstDayOfWeek = 0;
    this.autoWidth = false;
    this.autoWidthAnimationTime = 500;
    this.timeline_start = null;
    this.timeline_stop = null;
    this.ether = {backgroundColors: [], highlightOpacity: 50, interval: {line: {show: true, opacity: 25}, weekend: {opacity: 30}, marker: {hAlign: "Bottom", vAlign: "Right"}}};
    this.event = {
        track: {height: 10, gap: 2, offset: 2, autoWidthMargin: 1.5},
        overviewTrack: {offset: 20, tickHeight: 6, height: 2, gap: 1, autoWidthMargin: 5},
        tape: {height: 4},
        instant: {icon: Timeline.urlPrefix + "images/dull-blue-circle.png", iconWidth: 10, iconHeight: 10, impreciseOpacity: 20, impreciseIconMargin: 3},
        duration: {impreciseOpacity: 20},
        label: {backgroundOpacity: 50, offsetFromLine: 3},
        highlightColors: ["#ff0", "#ffc000", "#f00", "#00f"],
        highlightLabelBackground: false,
        bubble: {
            width: 250, maxHeight: 0, titleStyler: function (A) {
                A.className = "timeline-event-bubble-title";
            }, bodyStyler: function (A) {
                A.className = "timeline-event-bubble-body";
            }, imageStyler: function (A) {
                A.className = "timeline-event-bubble-image";
            }, wikiStyler: function (A) {
                A.className = "timeline-event-bubble-wiki";
            }, timeStyler: function (A) {
                A.className = "timeline-event-bubble-time";
            }
        }
    };
    this.mouseWheel = "scroll";
};


/* timeline.js */
Timeline.version = "2.3.1";
Timeline.ajax_lib_version = SimileAjax.version;
Timeline.display_version = Timeline.version + " (with Ajax lib " + Timeline.ajax_lib_version + ")";
Timeline.strings = {};
Timeline.HORIZONTAL = 0;
Timeline.VERTICAL = 1;
Timeline._defaultTheme = null;
Timeline.getDefaultLocale = function () {
    return Timeline.clientLocale;
};
Timeline.create = function (D, C, B, F) {
    if (Timeline.timelines == null) {
        Timeline.timelines = [];
    }
    var A = Timeline.timelines.length;
    Timeline.timelines[A] = null;
    var E = new Timeline._Impl(D, C, B, F, A);
    Timeline.timelines[A] = E;
    return E;
};
Timeline.createBandInfo = function (D) {
    var E = ("theme" in D) ? D.theme : Timeline.getDefaultTheme();
    var B = ("eventSource" in D) ? D.eventSource : null;
    var F = new Timeline.LinearEther({centersOn: ("date" in D) ? D.date : new Date(), interval: SimileAjax.DateTime.gregorianUnitLengths[D.intervalUnit], pixelsPerInterval: D.intervalPixels, theme: E});
    var G = new Timeline.GregorianEtherPainter({unit: D.intervalUnit, multiple: ("multiple" in D) ? D.multiple : 1, theme: E, align: ("align" in D) ? D.align : undefined});
    var I = {showText: ("showEventText" in D) ? D.showEventText : true, theme: E};
    if ("eventPainterParams" in D) {
        for (var A in D.eventPainterParams) {
            I[A] = D.eventPainterParams[A];
        }
    }
    if ("trackHeight" in D) {
        I.trackHeight = D.trackHeight;
    }
    if ("trackGap" in D) {
        I.trackGap = D.trackGap;
    }
    var H = ("overview" in D && D.overview) ? "overview" : ("layout" in D ? D.layout : "original");
    var C;
    if ("eventPainter" in D) {
        C = new D.eventPainter(I);
    } else {
        switch (H) {
            case"overview":
                C = new Timeline.OverviewEventPainter(I);
                break;
            case"detailed":
                C = new Timeline.DetailedEventPainter(I);
                break;
            default:
                C = new Timeline.OriginalEventPainter(I);
        }
    }
    return {width: D.width, eventSource: B, timeZone: ("timeZone" in D) ? D.timeZone : 0, ether: F, etherPainter: G, eventPainter: C, theme: E, zoomIndex: ("zoomIndex" in D) ? D.zoomIndex : 0, zoomSteps: ("zoomSteps" in D) ? D.zoomSteps : null};
};
Timeline.createHotZoneBandInfo = function (D) {
    var E = ("theme" in D) ? D.theme : Timeline.getDefaultTheme();
    var B = ("eventSource" in D) ? D.eventSource : null;
    var F = new Timeline.HotZoneEther({centersOn: ("date" in D) ? D.date : new Date(), interval: SimileAjax.DateTime.gregorianUnitLengths[D.intervalUnit], pixelsPerInterval: D.intervalPixels, zones: D.zones, theme: E});
    var G = new Timeline.HotZoneGregorianEtherPainter({unit: D.intervalUnit, zones: D.zones, theme: E, align: ("align" in D) ? D.align : undefined});
    var I = {showText: ("showEventText" in D) ? D.showEventText : true, theme: E};
    if ("eventPainterParams" in D) {
        for (var A in D.eventPainterParams) {
            I[A] = D.eventPainterParams[A];
        }
    }
    if ("trackHeight" in D) {
        I.trackHeight = D.trackHeight;
    }
    if ("trackGap" in D) {
        I.trackGap = D.trackGap;
    }
    var H = ("overview" in D && D.overview) ? "overview" : ("layout" in D ? D.layout : "original");
    var C;
    if ("eventPainter" in D) {
        C = new D.eventPainter(I);
    } else {
        switch (H) {
            case"overview":
                C = new Timeline.OverviewEventPainter(I);
                break;
            case"detailed":
                C = new Timeline.DetailedEventPainter(I);
                break;
            default:
                C = new Timeline.OriginalEventPainter(I);
        }
    }
    return {width: D.width, eventSource: B, timeZone: ("timeZone" in D) ? D.timeZone : 0, ether: F, etherPainter: G, eventPainter: C, theme: E, zoomIndex: ("zoomIndex" in D) ? D.zoomIndex : 0, zoomSteps: ("zoomSteps" in D) ? D.zoomSteps : null};
};
Timeline.getDefaultTheme = function () {
    if (Timeline._defaultTheme == null) {
        Timeline._defaultTheme = Timeline.ClassicTheme.create(Timeline.getDefaultLocale());
    }
    return Timeline._defaultTheme;
};
Timeline.setDefaultTheme = function (A) {
    Timeline._defaultTheme = A;
};
Timeline.loadXML = function (A, C) {
    var D = function (G, E, F) {
        alert("Failed to load data xml from " + A + "\n" + G);
    };
    var B = function (F) {
        var E = F.responseXML;
        if (!E.documentElement && F.responseStream) {
            E.load(F.responseStream);
        }
        C(E, A);
    };
    SimileAjax.XmlHttp.get(A, D, B);
};
Timeline.loadJSON = function (url, f) {
    var fError = function (statusText, status, xmlhttp) {
        alert("Failed to load json data from " + url + "\n" + statusText);
    };
    var fDone = function (xmlhttp) {
        f(eval("(" + xmlhttp.responseText + ")"), url);
    };
    SimileAjax.XmlHttp.get(url, fError, fDone);
};
Timeline.getTimelineFromID = function (A) {
    return Timeline.timelines[A];
};
Timeline.writeVersion = function (A) {
    document.getElementById(A).innerHTML = this.display_version;
};
Timeline._Impl = function (D, C, B, E, A) {
    SimileAjax.WindowManager.initialize();
    this._containerDiv = D;
    this._bandInfos = C;
    this._orientation = B == null ? Timeline.HORIZONTAL : B;
    this._unit = (E != null) ? E : SimileAjax.NativeDateUnit;
    this._starting = true;
    this._autoResizing = false;
    this.autoWidth = C && C[0] && C[0].theme && C[0].theme.autoWidth;
    this.autoWidthAnimationTime = C && C[0] && C[0].theme && C[0].theme.autoWidthAnimationTime;
    this.timelineID = A;
    this.timeline_start = C && C[0] && C[0].theme && C[0].theme.timeline_start;
    this.timeline_stop = C && C[0] && C[0].theme && C[0].theme.timeline_stop;
    this.timeline_at_start = false;
    this.timeline_at_stop = false;
    this._initialize();
};
Timeline._Impl.prototype.dispose = function () {
    for (var A = 0;
         A < this._bands.length;
         A++) {
        this._bands[A].dispose();
    }
    this._bands = null;
    this._bandInfos = null;
    this._containerDiv.innerHTML = "";
    Timeline.timelines[this.timelineID] = null;
};
Timeline._Impl.prototype.getBandCount = function () {
    return this._bands.length;
};
Timeline._Impl.prototype.getBand = function (A) {
    return this._bands[A];
};
Timeline._Impl.prototype.finishedEventLoading = function () {
    this._autoWidthCheck(true);
    this._starting = false;
};
Timeline._Impl.prototype.layout = function () {
    this._autoWidthCheck(true);
    this._distributeWidths();
};
Timeline._Impl.prototype.paint = function () {
    for (var A = 0;
         A < this._bands.length;
         A++) {
        this._bands[A].paint();
    }
};
Timeline._Impl.prototype.getDocument = function () {
    return this._containerDiv.ownerDocument;
};
Timeline._Impl.prototype.addDiv = function (A) {
    this._containerDiv.appendChild(A);
};
Timeline._Impl.prototype.removeDiv = function (A) {
    this._containerDiv.removeChild(A);
};
Timeline._Impl.prototype.isHorizontal = function () {
    return this._orientation == Timeline.HORIZONTAL;
};
Timeline._Impl.prototype.isVertical = function () {
    return this._orientation == Timeline.VERTICAL;
};
Timeline._Impl.prototype.getPixelLength = function () {
    return this._orientation == Timeline.HORIZONTAL ? this._containerDiv.offsetWidth : this._containerDiv.offsetHeight;
};
Timeline._Impl.prototype.getPixelWidth = function () {
    return this._orientation == Timeline.VERTICAL ? this._containerDiv.offsetWidth : this._containerDiv.offsetHeight;
};
Timeline._Impl.prototype.getUnit = function () {
    return this._unit;
};
Timeline._Impl.prototype.getWidthStyle = function () {
    return this._orientation == Timeline.HORIZONTAL ? "height" : "width";
};
Timeline._Impl.prototype.loadXML = function (B, D) {
    var A = this;
    var E = function (H, F, G) {
        alert("Failed to load data xml from " + B + "\n" + H);
        A.hideLoadingMessage();
    };
    var C = function (G) {
        try {
            var F = G.responseXML;
            if (!F.documentElement && G.responseStream) {
                F.load(G.responseStream);
            }
            D(F, B);
        } finally {
            A.hideLoadingMessage();
        }
    };
    this.showLoadingMessage();
    window.setTimeout(function () {
        SimileAjax.XmlHttp.get(B, E, C);
    }, 0);
};
Timeline._Impl.prototype.loadJSON = function (url, f) {
    var tl = this;
    var fError = function (statusText, status, xmlhttp) {
        alert("Failed to load json data from " + url + "\n" + statusText);
        tl.hideLoadingMessage();
    };
    var fDone = function (xmlhttp) {
        try {
            f(eval("(" + xmlhttp.responseText + ")"), url);
        } finally {
            tl.hideLoadingMessage();
        }
    };
    this.showLoadingMessage();
    window.setTimeout(function () {
        SimileAjax.XmlHttp.get(url, fError, fDone);
    }, 0);
};
Timeline._Impl.prototype._autoWidthScrollListener = function (A) {
    A.getTimeline()._autoWidthCheck(false);
};
Timeline._Impl.prototype._autoWidthCheck = function (C) {
    var E = this;
    var B = E._starting;
    var D = 0;

    function A() {
        var H = E.getWidthStyle();
        if (B) {
            E._containerDiv.style[H] = D + "px";
        } else {
            E._autoResizing = true;
            var G = {};
            G[H] = D + "px";
            SimileAjax.jQuery(E._containerDiv).animate(G, E.autoWidthAnimationTime, "linear", function () {
                E._autoResizing = false;
            });
        }
    }

    function F() {
        var I = 0;
        var G = E.getPixelWidth();
        if (E._autoResizing) {
            return;
        }
        for (var H = 0;
             H < E._bands.length;
             H++) {
            E._bands[H].checkAutoWidth();
            I += E._bandInfos[H].width;
        }
        if (I > G || C) {
            D = I;
            A();
            E._distributeWidths();
        }
    }

    if (!E.autoWidth) {
        return;
    }
    F();
};
Timeline._Impl.prototype._initialize = function () {
    var H = this._containerDiv;
    var E = H.ownerDocument;
    H.className = H.className.split(" ").concat("timeline-container").join(" ");
    var B = (this.isHorizontal()) ? "horizontal" : "vertical";
    H.className += " timeline-" + B;
    while (H.firstChild) {
        H.removeChild(H.firstChild);
    }
    var A = SimileAjax.Graphics.createTranslucentImage(Timeline.urlPrefix + (this.isHorizontal() ? "images/copyright-vertical.png" : "images/copyright.png"));
    A.className = "timeline-copyright";
    A.title = "Timeline copyright SIMILE - www.simile-widgets.org/";
    SimileAjax.DOM.registerEvent(A, "click", function () {
        window.location = "http://www.simile-widgets.org/";
    });
    H.appendChild(A);
    this._bands = [];
    for (var C = 0;
         C < this._bandInfos.length;
         C++) {
        var G = new Timeline._Band(this, this._bandInfos[C], C);
        this._bands.push(G);
    }
    this._distributeWidths();
    for (var C = 0;
         C < this._bandInfos.length;
         C++) {
        var F = this._bandInfos[C];
        if ("syncWith" in F) {
            this._bands[C].setSyncWithBand(this._bands[F.syncWith], ("highlight" in F) ? F.highlight : false);
        }
    }
    if (this.autoWidth) {
        for (var C = 0;
             C < this._bands.length;
             C++) {
            this._bands[C].addOnScrollListener(this._autoWidthScrollListener);
        }
    }
    var D = SimileAjax.Graphics.createMessageBubble(E);
    D.containerDiv.className = "timeline-message-container";
    H.appendChild(D.containerDiv);
    D.contentDiv.className = "timeline-message";
    D.contentDiv.innerHTML = "<img src='" + Timeline.urlPrefix + "images/progress-running.gif'> Loading...";
    this.showLoadingMessage = function () {
        D.containerDiv.style.display = "block";
    };
    this.hideLoadingMessage = function () {
        D.containerDiv.style.display = "none";
    };
};
Timeline._Impl.prototype._distributeWidths = function () {
    var B = this.getPixelLength();
    var A = this.getPixelWidth();
    var C = 0;
    for (var E = 0;
         E < this._bands.length;
         E++) {
        var I = this._bands[E];
        var J = this._bandInfos[E];
        var F = J.width;
        var D;
        if (typeof F == "string") {
            var H = F.indexOf("%");
            if (H > 0) {
                var G = parseInt(F.substr(0, H));
                D = Math.round(G * A / 100);
            } else {
                D = parseInt(F);
            }
        } else {
            D = F;
        }
        I.setBandShiftAndWidth(C, D);
        I.setViewLength(B);
        C += D;
    }
};
Timeline._Impl.prototype.shiftOK = function (D, B) {
    var C = B > 0, A = B < 0;
    if ((C && this.timeline_start == null) || (A && this.timeline_stop == null) || (B == 0)) {
        return (true);
    }
    var G = false;
    for (var F = 0;
         F < this._bands.length && !G;
         F++) {
        G = this._bands[F].busy();
    }
    if (G) {
        return (true);
    }
    if ((C && this.timeline_at_start) || (A && this.timeline_at_stop)) {
        return (false);
    }
    var E = false;
    for (var F = 0;
         F < this._bands.length && !E;
         F++) {
        var H = this._bands[F];
        if (C) {
            E = (F == D ? H.getMinVisibleDateAfterDelta(B) : H.getMinVisibleDate()) >= this.timeline_start;
        } else {
            E = (F == D ? H.getMaxVisibleDateAfterDelta(B) : H.getMaxVisibleDate()) <= this.timeline_stop;
        }
    }
    if (C) {
        this.timeline_at_start = !E;
        this.timeline_at_stop = false;
    } else {
        this.timeline_at_stop = !E;
        this.timeline_at_start = false;
    }
    return (E);
};
Timeline._Impl.prototype.zoom = function (G, B, F, D) {
    var C = new RegExp("^timeline-band-([0-9]+)$");
    var E = null;
    var A = C.exec(D.id);
    if (A) {
        E = parseInt(A[1]);
    }
    if (E != null) {
        this._bands[E].zoom(G, B, F, D);
    }
    this.paint();
};


/* units.js */
Timeline.NativeDateUnit = new Object();
Timeline.NativeDateUnit.createLabeller = function (A, B) {
    return new Timeline.GregorianDateLabeller(A, B);
};
Timeline.NativeDateUnit.makeDefaultValue = function () {
    return new Date();
};
Timeline.NativeDateUnit.cloneValue = function (A) {
    return new Date(A.getTime());
};
Timeline.NativeDateUnit.getParser = function (A) {
    if (typeof A == "string") {
        A = A.toLowerCase();
    }
    return (A == "iso8601" || A == "iso 8601") ? Timeline.DateTime.parseIso8601DateTime : Timeline.DateTime.parseGregorianDateTime;
};
Timeline.NativeDateUnit.parseFromObject = function (A) {
    return Timeline.DateTime.parseGregorianDateTime(A);
};
Timeline.NativeDateUnit.toNumber = function (A) {
    return A.getTime();
};
Timeline.NativeDateUnit.fromNumber = function (A) {
    return new Date(A);
};
Timeline.NativeDateUnit.compare = function (D, C) {
    var B, A;
    if (typeof D == "object") {
        B = D.getTime();
    } else {
        B = Number(D);
    }
    if (typeof C == "object") {
        A = C.getTime();
    } else {
        A = Number(C);
    }
    return B - A;
};
Timeline.NativeDateUnit.earlier = function (B, A) {
    return Timeline.NativeDateUnit.compare(B, A) < 0 ? B : A;
};
Timeline.NativeDateUnit.later = function (B, A) {
    return Timeline.NativeDateUnit.compare(B, A) > 0 ? B : A;
};
Timeline.NativeDateUnit.change = function (A, B) {
    return new Date(A.getTime() + B);
};
