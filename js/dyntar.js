/*************************************************************\
 *	DYNTAR - Dynamic TextArea Resizer v1.0.0
 *
 *	Copyright (C) 2004, Markus (phpMiX)
 *	This script is released under GPL License.
 *	Feel free to use this script (or part of it) wherever you need
 *	it ...but please, give credit to original author. Thank you. :-)
 *	We will also appreciate any links you could give us.
 *
 *	Enjoy! ;-)
\*************************************************************/

var DYNTAR = {
	is: false,
	min: 50,
	init: function() {
		with(document) if (getElementsByTagName && createElement && insertBefore && appendChild) {
			this.oldload = window.onload;
			window.onload = this.onload;
		}
	},
	onload: function() {
		if (DYNTAR.oldload) {DYNTAR.oldload();DYNTAR.oldload=null;}
		var x = document.getElementsByTagName('textarea');
		for (var i=0;i<x.length;i++) {DYNTAR.attach(x[i]);}
	},
	attach: function(ta) {
		if (!ta.getAttribute || ta.getAttribute('noresize')) return;
		var parent = ta.parentNode;
		var wp = document.createElement('div');
		var rz = document.createElement('div');
		if (!parent||!wp||!rz) return;
		wp.style.width = ta.offsetWidth + 'px';
		rz.className = 'dyntar-resizer';
		rz.style.width = (ta.offsetWidth-2) + 'px';
		rz._wp = wp;
		rz._ta = ta;
		parent.insertBefore(wp,ta);
		wp.appendChild(ta);
		wp.appendChild(rz);
		rz.onmousedown = function(e) {DYNTAR.onmousedown(e,this);}
	},
	onmousedown: function(e,rz) {
		if (this.is||!rz._wp) return;
		if (!e) e = window.event;
		this.is = {rz:rz,wp:rz._wp,ta:rz._ta,h:rz._ta.offsetHeight,y:e.clientY};
		with(this.is) {
			ta.className += ' dyntar-active';
			wp.className = 'dyntar-wrapper';
		}
		this.oldmousemove = document.onmousemove;
		this.oldmouseup = document.onmouseup;
		document.onmousemove = function(e){DYNTAR.onmousemove(e);}
		document.onmouseup = function(e){DYNTAR.onmouseup(e);}
	},
	onmouseup: function(e) {
		if (!this.is) return;
		with(this.is) {
			ta.className = ta.className.replace(/ *dyntar-active/, '');
			wp.className = '';
		}
		this.is = false;
		document.onmousemove = this.oldmousemove;
		document.onmouseup = this.oldmouseup;
	},
	onmousemove: function(e) {
		if (!this.is) return;
		if (!e) e = window.event;
		this.is.ta.style.height = Math.max(this.min,this.is.h+e.clientY-this.is.y) + 'px';
		this.cancel_event(e);
		return false;
	},
	cancel_event: function(e) {
		if (e.preventDefault) e.preventDefault();
		if (e.stopPropagation) e.stopPropagation();
		e.cancelBubble = true;
		e.returnValue = false;
	}
};
DYNTAR.init();
