export function useToast() {
  return {
    toast: {
      show: false,
      message: ''
    },
    showToast(message, type = 'success') {
      this.toast.message = message;
      this.toast.show = true;
      setTimeout(() => this.toast.show = false, 3500);
    }
  };
}
