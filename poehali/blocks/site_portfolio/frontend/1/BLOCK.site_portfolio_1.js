document.addEventListener("DOMContentLoaded", function(event) {
	BLOCK.site_portfolio.start()
});


BLOCK.site_portfolio = {
	start: function(){
		if (!DAN) return

		let items_arr = document.getElementsByClassName("block_site_profile_item_wrap");
		let images_arr = document.getElementsByClassName("block_site_profile_item_image");

		// Размытие
		for(i = 0; i < items_arr.length; i++){		
			items_arr[i].onmouseover = function(){
				this.parentNode.classList.add('block_site_portfolio_container_hover')
			}

			items_arr[i].onmouseout = function(){
				this.parentNode.classList.remove('block_site_portfolio_container_hover')
			}
		}

		// Скролл
		for(i = 0; i < images_arr.length; i++){
			images_arr[i].onmouseover = function(){
				let img_h = this.offsetHeight;
				let patent_h = this.parentNode.offsetHeight;
				if(img_h > patent_h)
				{
					let position_top = patent_h - img_h;
					this.style.top = position_top + 'px';
					this.style.transition = ((img_h - patent_h) * 2/ patent_h) + 's linear';
				}
			}

			images_arr[i].onmouseout = function(){
				this.style.top = 0;
				this.style.transition = '0.5s';
			}
		}
	}
}