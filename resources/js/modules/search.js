export function useSearch(products) {
  return {
    search: '',
    products: products,

    get filteredProducts() {
      return this.products.filter(p =>
        p.name.toLowerCase().includes(this.search.toLowerCase())
      );
    }
  };
}
