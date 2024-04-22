class CopyrightYear extends HTMLElement{
    connectedCallback(){
        this.innerHTML = new Date().getFullYear();
    }
}

customElements.define("x-year", CopyrightYear);


class TwoSidedMarket extends HTMLElement{
	connectedCallback(){
		this.innerHTML = `<a href="Blog">Blog</a>&nbsp;&nbsp;&nbsp;<a href="Market">Market</a>`;
	}
}

customElements.define("x-twosided", TwoSidedMarket);
