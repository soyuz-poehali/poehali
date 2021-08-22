window.addEventListener('DOMContentLoaded', function(){
	BLOCK.buttonup.start()
	window.addEventListener("scroll", BLOCK.buttonup.start);
	if(DAN.$('block_buttonup')) 
		DAN.$('block_buttonup').onclick = DAN.jumpTo;
})

BLOCK.buttonup = {
	MAX_OPACITY: 0.7,
	MIN_OPACITY: 0,
	SPEED_TO_TOP: 70,

	start: function(){
		var heightDocument = document.documentElement.clientHeight;
		var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
		var button = document.getElementById('block_buttonup');

		if (button != null) {
			if (scrollTop > (heightDocument / 2)) {
				var opacityNew = scrollTop / ((heightDocument * 2) / 100);
				opacityNew /= 100;
				if (opacityNew > BLOCK.buttonup.MAX_OPACITY) opacityNew = BLOCK.buttonup.MAX_OPACITY
				button.style.opacity = opacityNew;
				button.style.display = "block"
			} else {
				button.style.opacity = BLOCK.buttonup.MIN_OPACITY;
				button.style.display = "none"
			}
		}
	}
}