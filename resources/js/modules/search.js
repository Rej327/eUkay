export function useSearch(products) {
  return {
    search: 'shiva',
    products: products,

    get filteredProducts() {
      return this.products.filter(p =>
        p.name.toLowerCase().includes(this.search.toLowerCase())
      );
    }
  };
}
