// Gerenciador de Carrinho
class CartManager {
    constructor() {
        this.cart = {};
        this.precos = {};
        this.loadCart();
    }

    loadCart() {
        const saved = localStorage.getItem('cardapio_cart');
        if (saved) {
            this.cart = JSON.parse(saved);
        }
    }

    saveCart() {
        localStorage.setItem('cardapio_cart', JSON.stringify(this.cart));
        this.updateUI();
    }

    addItem(id, nome, preco) {
        this.precos[id] = preco;
        
        if (!this.cart[id]) {
            this.cart[id] = {
                id,
                nome,
                quantidade: 0,
                observacoes: ''
            };
        }
        
        this.cart[id].quantidade++;
        this.saveCart();
    }

    removeItem(id) {
        if (this.cart[id]) {
            this.cart[id].quantidade--;
            if (this.cart[id].quantidade <= 0) {
                delete this.cart[id];
            }
            this.saveCart();
        }
    }

    updateObservacoes(id, texto) {
        if (this.cart[id]) {
            this.cart[id].observacoes = texto;
            this.saveCart();
        }
    }

    getTotal() {
        let total = 0;
        for (const id in this.cart) {
            total += this.precos[id] * this.cart[id].quantidade;
        }
        return total.toFixed(2);
    }

    getItemCount() {
        let count = 0;
        for (const id in this.cart) {
            count += this.cart[id].quantidade;
        }
        return count;
    }

    getCartData() {
        return Object.values(this.cart);
    }

    updateUI() {
        const cartCount = document.getElementById('cart-count');
        const cartTotal = document.getElementById('cart-total');
        
        if (cartCount) {
            cartCount.textContent = this.getItemCount();
        }
        
        if (cartTotal) {
            cartTotal.textContent = `R$ ${this.getTotal()}`;
        }

        // Atualizar quantidade exibida para cada produto
        for (const id in this.cart) {
            const span = document.getElementById(`qtd-${id}`);
            if (span) {
                span.textContent = this.cart[id].quantidade;
            }
        }
    }

    clear() {
        this.cart = {};
        this.saveCart();
    }
}

// Inicializar carrinho global
const cart = new CartManager();

function aumentar(id, nome, preco) {
    cart.addItem(id, nome, preco);
}

function diminuir(id) {
    cart.removeItem(id);
}

function atualizarObservacoes(id, textarea) {
    cart.updateObservacoes(id, textarea.value);
}

function enviarPedido() {
    const itens = cart.getCartData();
    
    if (itens.length === 0) {
        alert('Adicione itens ao carrinho!');
        return;
    }

    // Enviar pedido via form POST
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '/pedidos';
    
    form.innerHTML = `
        <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').content}">
        <input type="hidden" name="itens" value='${JSON.stringify(itens)}'>
        <input type="hidden" name="observacoes" value="${cart.cart[Object.keys(cart.cart)[0]]?.observacoes || ''}">
    `;
    
    document.body.appendChild(form);
    form.submit();
}

document.addEventListener('DOMContentLoaded', function() {
    cart.updateUI();
});
