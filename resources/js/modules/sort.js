export function useSort() {
  return {
    sortBy: 'name',
    sortDir: 'asc',

    sort(column) {
      if (this.sortBy === column) {
        this.sortDir = this.sortDir === 'asc' ? 'desc' : 'asc';
      } else {
        this.sortBy = column;
        this.sortDir = 'asc';
      }
    }
  };
}
