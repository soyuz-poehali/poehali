window.addEventListener('DOMContentLoaded', () => {
    DAN.show("show", "block_catalog_item_1_container");
    DAN.show("show_2", "block_catalog_item_1_container");

    BLOCK.catalog.init();
});

BLOCK.catalog = {
    chars_secected: false,

    // Навешиваем события на элементы select характеристик, влияющих на цену
    init(){
        BLOCK.catalog.chars_secected = document.getElementsByClassName('dan_input bcicv')
        for (let i = 0; i < BLOCK.catalog.chars_secected.length; i++) {
            BLOCK.catalog.chars_secected[i].onchange = BLOCK.catalog.calc
        }
    },

    // Расчёт стоимости
    calc(){
        let price = parseInt(DAN.$('block_catalog_item_1_price').dataset.price)
        for (let i = 0; i < BLOCK.catalog.chars_secected.length; i++) {
            let option = BLOCK.catalog.chars_secected[i].options[BLOCK.catalog.chars_secected[i].selectedIndex]
            price += parseInt(option.dataset.price)
        }
        DAN.$('block_catalog_item_1_price').innerHTML = price
    }
}