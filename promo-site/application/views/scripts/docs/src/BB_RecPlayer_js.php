<div><p><br/></p></div><div class="container">

	
	
	


	<div class="row">
		<div id="index" class="col-md-3">
			
			<div >
	<div class="panel panel-default">
		<div class="panel-heading">Classes</div>
		
			<div class="panel-body"><a href="/docs/api/BB_Frame"><span class="indent" style="padding-left:14px;"><i class="icon-jsdoc icon-jsdoc-class"></i><span class="jsdoc-class-index">Frame</span></span></a></div>
		
			<div class="panel-body"><a href="/docs/api/BB_RecPlayer"><span class="indent" style="padding-left:14px;"><i class="icon-jsdoc icon-jsdoc-class"></i><span class="jsdoc-class-index">RecPlayer</span></span></a></div>
		
			<div class="panel-body"><a href="/docs/api/BB_Recording"><span class="indent" style="padding-left:14px;"><i class="icon-jsdoc icon-jsdoc-class"></i><span class="jsdoc-class-index">Recording</span></span></a></div>
		
			<div class="panel-body"><a href="/docs/api/BB_Session"><span class="indent" style="padding-left:14px;"><i class="icon-jsdoc icon-jsdoc-class"></i><span class="jsdoc-class-index">Session</span></span></a></div>
		
			<div class="panel-body"><a href="/docs/api/_global_"><span class="indent" style="padding-left:0px;"><i class="icon-jsdoc icon-jsdoc-namespace"></i><span class="jsdoc-class-index">_global_</span></span></a></div>
		
	</div>
</div>

			
		</div>

		<div id="content" class="col-md-9">


			<pre  class="prettyprint linenums">goog.provide('BB.RecPlayer');

/**
 *
 * @param {BB.Recording=} recording
 *
 * @constructor
 */
BB.RecPlayer = function(recording) {
    /** @type {BB.Recording|Object} */
    this.recording = recording || {};

    /** @type {Node} */
    this.win = document.createElement('div');

    /** @type {Node} */
    this.viewport = document.createElement('div');

    /** @type {Node} */
    this.doc = document.createElement('iframe');

    /** @type {Element} */
    this.mouse = document.createElement('img');

    /** @type {Object.&lt;string, number&gt;} */
    this.ticks = {
        FRAME_DUR_MILLI: 0,
        FRAME_DUR_SEC: 0
    };

    /** @type {Object.&lt;string, number&gt;} */
    this.frames = {
        TOTAL: 0,
        CURRENT: 0
    };

    /**
     * @type {boolean}
     * @private
     */
    this.active = false;

    /**
     * @type {Element}
     * @private
     */
    this._mouseOn = new Image();

    /**
     * @type {Element}
     * @private
     */
    this._mouseOff = new Image();

    this.init();
};

/**
 *
 */
BB.RecPlayer.prototype.init = function(){
    // Preload and cache icons
    this._mouseOn.src = '/img/mouse-on.png';
    this._mouseOff.src = '/img/mouse-off.png';

    this.win.className = 'bb-win';
    this.viewport.className = 'bb-vp';
    this.doc.className = 'bb-doc';
    this.mouse.className = 'bb-mouse';

    this.mouse._width = 32;
    this.mouse._height = 32;
    this.mouse._centerX = parseInt(this.mouse._width * 0.5, 10);
    this.mouse._centerY = parseInt(this.mouse._height * 0.5, 10);
    this.mouse.style.left = '-100px';
    this.mouse.style.top = '-100px';
    this.mouse.src = this._mouseOff.src;

    this.win.appendChild(this.mouse);
    this.win.appendChild(this.viewport);
    this.viewport.appendChild(this.doc);
};

/**
 *
 * @param {BB.Recording} recording
 */
BB.RecPlayer.prototype.setRecording = function(recording) {
    this.recording = recording;

    this.active = false;
};

/**
 *
 * @param {number} x
 * @param {number} y
 */
BB.RecPlayer.prototype.centerMouse = function(x, y) {
    this.mouse.style.left = (x - this.mouse._centerX) + 'px';
    this.mouse.style.top = (y - this.mouse._centerY) + 'px';
};

/**
 *
 */
BB.RecPlayer.prototype.tick = function() {
    var frame = this.recording.frames[this.frames.CURRENT];

    this.centerMouse(frame.mouse.x, frame.mouse.y);

    if (frame.clicked) {
        this.mouse.src = this._mouseOn.src;
    } else {
        this.mouse.src = this._mouseOff.src;
    }

    this.frames.CURRENT++;

    if (this.frames.CURRENT &lt; this.frames.TOTAL) {
        setTimeout(this.tick.bind(this), this.ticks.FRAME_DUR_MILLI);
}
};


/**
 *
 * @param {Node} panel
 */
BB.RecPlayer.prototype.go = function(panel) {
    if (!this.active &amp;&amp; this.recording !== {}) {
        var clone;

        while (panel.firstChild) {
            clone = panel.firstChild.cloneNode(false);
            panel.replaceChild(clone, panel.firstChild);
        }

        this.ticks.FRAME_DUR_MILLI = 1000 / this.recording.fps;
        this.ticks.FRAME_DUR_SEC = this.recording.fps / 1000;

        this.frames.TOTAL = this.recording.frames.length;
        this.frames.CURRENT = 0;

        this.win.style.width = this.recording.res.width + 'px';
        this.win.style.height = this.recording.res.height + 'px';

        this.viewport.style.width = this.recording.frames[0].win.width + 'px';
        this.viewport.style.height = this.recording.frames[0].win.height + 'px';

        this.doc.style.width = this.recording.frames[0].win.width + 'px';
        this.doc.style.height = this.recording.frames[0].win.height + 'px';
        this.doc.src = this.recording.url;

        this.mouse.style.transitionDuration = this.ticks.FRAME_DUR_SEC + 's';

        this.centerMouse(this.recording.frames[0].mouse.x, this.recording.frames[0].mouse.y);

        panel.appendChild(this.win);

        this.active = true;
        this.tick();
    }
};

		</div>
	</div>


	
</div>
<script type="text/javascript">
	prettyPrint();
	var i = 1;
	$('#source-code li').each(function() {
		$(this).attr({ id: 'line' + (i++) });
	});
</script>
</div></div>