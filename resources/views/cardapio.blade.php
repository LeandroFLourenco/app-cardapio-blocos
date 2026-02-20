@extends('layouts.app')

@section('title', 'Cardápio')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/cardapio.css') }}">
@endpush

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Grid de Produtos -->
        <div class="lg:col-span-2">
            <h1 class="text-4xl font-bold text-gray-800 mb-8">Nosso Cardápio</h1>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 product-grid">
                @forelse($produtos as $produto)
                    <div class="card bg-white rounded-lg shadow-md overflow-hidden border border-gray-100">
                        <img src="{{ $produto->imagem }}" alt="{{ $produto->nome }}" class="product-image w-full">
                        
                        <div class="p-4">
                            <h3 class="text-lg font-bold text-gray-800 mb-2">{{ $produto->nome }}</h3>
                            
                            <p class="text-sm text-gray-600 mb-3">{{ $produto->descricao }}</p>
                            
                            <div class="flex justify-between items-center mb-4">
                                <span class="price-tag">R$ {{ number_format($produto->preco, 2, ',', '.') }}</span>
                                <span class="text-xs text-green-600 font-semibold">Estoque: {{ $produto->quantidade }}</span>
                            </div>

                            <div class="flex items-center justify-between mb-3 gap-2">
                                <button onclick="diminuir({{ $produto->id }})" class="btn-decrement bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded transition">−</button>
                                <span id="qtd-{{ $produto->id }}" class="text-lg font-bold text-center flex-1">0</span>
                                <button onclick="aumentar({{ $produto->id }}, '{{ $produto->nome }}', {{ $produto->preco }})" class="btn-increment bg-green-500 hover:bg-green-600 text-white px-3 py-2 rounded transition">+</button>
                            </div>

                            <div>
                                <label class="text-sm text-gray-700 font-semibold mb-1 block">Observações:</label>
                                <textarea id="obs-{{ $produto->id }}" onchange="atualizarObservacoes({{ $produto->id }}, this)" class="w-full text-sm p-2 border border-gray-300 rounded resize-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500" placeholder="Ex: sem cebola, bem passado..." rows="2"></textarea>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-yellow-50 border border-yellow-200 rounded-lg p-6 text-center">
                        <p class="text-yellow-800">Nenhum produto disponível no momento.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Resumo do Carrinho (Sticky) -->
        <div class="lg:col-span-1">
            <div class="cart-summary bg-white rounded-lg shadow-md p-6 border border-gray-100">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">🛒 Seu Carrinho</h2>
                
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                    <p class="text-sm text-gray-600 mb-1">Total de itens</p>
                    <p class="text-3xl font-bold text-blue-600"><span id="cart-count">0</span></p>
                </div>

                <div class="bg-orange-50 border border-orange-200 rounded-lg p-4 mb-6">
                    <p class="text-sm text-gray-600 mb-1">Total</p>
                    <p class="text-3xl font-bold text-orange-600">
                        <span id="cart-total">R$ 0,00</span>
                    </p>
                </div>

                <button onclick="enviarPedido()" class="w-full bg-orange-600 hover:bg-orange-700 text-white font-bold py-3 rounded-lg transition transform hover:scale-105 mb-2">
                    Confirmar Pedido
                </button>

                <button onclick="cart.clear(); cart.updateUI();" class="w-full bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 rounded-lg transition">
                    Limpar Carrinho
                </button>

                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                    <p class="text-xs text-gray-600 text-center">
                        💡 Seu carrinho é salvo automaticamente no navegador
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Seleção de Pagamento -->
    <div id="modalPagamento" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-8 max-w-md w-full mx-4">
            <h2 class="text-2xl font-bold mb-6">💳 Forma de Pagamento</h2>
            
            <!-- Opções de Pagamento -->
            <div class="space-y-3 mb-6">
                <label class="flex items-center p-3 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-orange-500 transition">
                    <input type="radio" name="pagamento" value="pix" class="mr-3" onchange="selecionarPagamento('pix')">
                    <span class="text-lg">📱 PIX</span>
                </label>

                <label class="flex items-center p-3 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-orange-500 transition">
                    <input type="radio" name="pagamento" value="credito" class="mr-3" onchange="selecionarPagamento('credito')">
                    <span class="text-lg">💳 Cartão de Crédito</span>
                </label>

                <label class="flex items-center p-3 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-orange-500 transition">
                    <input type="radio" name="pagamento" value="debito" class="mr-3" onchange="selecionarPagamento('debito')">
                    <span class="text-lg">🏧 Cartão de Débito</span>
                </label>

                <label class="flex items-center p-3 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-orange-500 transition">
                    <input type="radio" name="pagamento" value="dinheiro" class="mr-3" onchange="selecionarPagamento('dinheiro')">
                    <span class="text-lg">💵 Dinheiro</span>
                </label>
            </div>

            <!-- Campo de Dinheiro (Aparece só se escolher Dinheiro) -->
            <div id="campoTroco" class="hidden mb-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    💰 Quanto você vai dar?
                </label>
                <input 
                    type="number" 
                    id="valorDinheiro" 
                    placeholder="Ex: 100" 
                    step="0.01"
                    min="0"
                    class="w-full p-2 border border-gray-300 rounded mb-3 focus:border-orange-500 focus:ring-1 focus:ring-orange-500"
                    oninput="calcularTroco()"
                >
                
                <div id="infoTroco" class="hidden">
                    <div class="bg-white p-3 rounded border-l-4 border-green-500">
                        <div class="text-sm text-gray-600">Total a pagar:</div>
                        <div class="text-lg font-bold text-gray-800" id="totalPagar">R$ 0,00</div>
                    </div>
                    <div class="bg-white p-3 rounded border-l-4 border-blue-500 mt-2">
                        <div class="text-sm text-gray-600">Valor do troco:</div>
                        <div class="text-lg font-bold text-blue-600" id="valorTroco">R$ 0,00</div>
                    </div>
                </div>
            </div>

            <!-- Botões -->
            <div class="flex flex-col gap-3">
                <button onclick="confirmarPagamento()" class="w-full bg-orange-600 hover:bg-orange-700 text-white font-bold py-3 rounded-lg transition">
                    ✅ Confirmar Pagamento
                </button>

                <button onclick="fecharModalPagamento()" class="w-full bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 rounded-lg transition">
                    ❌ Voltar
                </button>
            </div>
        </div>
    </div>

    <!-- Modal de Confirmação do Pedido -->
    <div id="modalPedido" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-8 max-w-md w-full mx-4">
            <h2 class="text-2xl font-bold mb-4">📋 Resumo do Pedido</h2>
            
            <div id="pedidoResumo" class="bg-gray-50 p-4 rounded-lg mb-4 max-h-60 overflow-y-auto">
                <!-- Conteúdo será preenchido via JavaScript -->
            </div>

            <div class="flex flex-col gap-3">
                <button onclick="copiarMensagemWhatsapp()" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg transition">
                    📋 Copiar Mensagem
                </button>
                
                <button onclick="enviarWhatsapp()" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                    💬 Enviar WhatsApp
                </button>
                
                <!-- <button onclick="confirmarPedidoServidor()" class="bg-orange-600 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded-lg transition">
                    ✅ Confirmar Pedido
                </button> -->

                <button onclick="fecharModal()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-lg transition">
                    ❌ Cancelar
                </button>
            </div>
        </div>
    </div>

    <!-- CSRF Token para formulário -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

<script>
// Gerenciador de Carrinho Global
class CartManager {
    constructor() {
        this.cart = {};
        this.precos = {};
        this.loadCart();
    }

    loadCart() {
        const savedCart = localStorage.getItem('cardapio_cart');
        const savedPrecos = localStorage.getItem('cardapio_precos');
        
        if (savedCart) {
            this.cart = JSON.parse(savedCart);
        }
        
        if (savedPrecos) {
            this.precos = JSON.parse(savedPrecos);
        }
    }

    saveCart() {
        localStorage.setItem('cardapio_cart', JSON.stringify(this.cart));
        localStorage.setItem('cardapio_precos', JSON.stringify(this.precos));
        this.updateUI();
    }

    addItem(id, nome, preco) {
        preco = parseFloat(preco);
        this.precos[id] = preco;
        
        if (!this.cart[id]) {
            this.cart[id] = {
                id,
                nome,
                preco,  // ← Guardar preço no item também
                quantidade: 0,
                observacoes: ''
            };
        }
        
        this.cart[id].quantidade++;
        this.saveCart();
        console.log('Adicionado:', nome, 'Quantidade:', this.cart[id].quantidade);
    }

    removeItem(id) {
        if (this.cart[id]) {
            this.cart[id].quantidade--;
            if (this.cart[id].quantidade <= 0) {
                delete this.cart[id];
            }
            this.saveCart();
            console.log('Removido item ' + id);
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
            const item = this.cart[id];
            // Prioridade: preço do item (salvo) > preço do objeto precos > 0
            const preco = parseFloat(item.preco) || parseFloat(this.precos[id]) || 0;
            
            if (preco > 0 && item.quantidade > 0) {
                total += preco * item.quantidade;
            }
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
            const total = this.getTotal();
            cartTotal.textContent = `R$ ${parseFloat(total).toLocaleString('pt-BR', {minimumFractionDigits: 2})}`;
        }

        // Atualizar quantidade exibida para cada produto
        for (const id in this.cart) {
            const span = document.getElementById(`qtd-${id}`);
            if (span) {
                span.textContent = this.cart[id].quantidade;
            }
        }

        // Resetar quantidade dos produtos não no carrinho
        document.querySelectorAll('[id^="qtd-"]').forEach(span => {
            const id = span.id.replace('qtd-', '');
            if (!this.cart[id]) {
                span.textContent = '0';
            }
        });
    }

    clear() {
        this.cart = {};
        this.precos = {};
        this.saveCart();
    }
}

// Instância global
const cart = new CartManager();

// Função: Aumentar quantidade
function aumentar(id, nome, preco) {
    console.log('Aumentar chamado para:', id, nome, preco);
    cart.addItem(id, nome, preco);
}

// Função: Diminuir quantidade
function diminuir(id) {
    console.log('Diminuir chamado para:', id);
    cart.removeItem(id);
}

// Função: Atualizar observações
function atualizarObservacoes(id, textarea) {
    cart.updateObservacoes(id, textarea.value);
}

// ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
// FUNÇÕES DE PAGAMENTO
// ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

// Variável global para armazenar forma de pagamento
let metodoPagamento = null;
let valorDinheiro = 0;

// Função: Abrir modal de pagamento
function abrirModalPagamento() {
    const itens = cart.getCartData();
    
    if (itens.length === 0) {
        alert('❌ Adicione itens ao carrinho!');
        return;
    }
    
    metodoPagamento = null;
    valorDinheiro = 0;
    document.getElementById('modalPagamento').classList.remove('hidden');
    document.getElementById('campoTroco').classList.add('hidden');
}

// Função: Selecionar forma de pagamento
function selecionarPagamento(metodo) {
    metodoPagamento = metodo;
    const campoTroco = document.getElementById('campoTroco');
    
    if (metodo === 'dinheiro') {
        campoTroco.classList.remove('hidden');
        document.getElementById('valorDinheiro').focus();
    } else {
        campoTroco.classList.add('hidden');
        document.getElementById('valorDinheiro').value = '';
        document.getElementById('infoTroco').classList.add('hidden');
    }
}

// Função: Calcular troco
function calcularTroco() {
    const valorInput = parseFloat(document.getElementById('valorDinheiro').value) || 0;
    const total = parseFloat(cart.getTotal());
    
    valorDinheiro = valorInput;
    
    if (valorInput >= total) {
        const troco = (valorInput - total).toFixed(2);
        document.getElementById('totalPagar').textContent = `R$ ${total.toLocaleString('pt-BR', {minimumFractionDigits: 2})}`;
        document.getElementById('valorTroco').textContent = `R$ ${parseFloat(troco).toLocaleString('pt-BR', {minimumFractionDigits: 2})}`;
        document.getElementById('infoTroco').classList.remove('hidden');
    } else {
        document.getElementById('infoTroco').classList.add('hidden');
    }
}

// Função: Confirmar pagamento e ir para resumo
function confirmarPagamento() {
    if (!metodoPagamento) {
        alert('❌ Selecione uma forma de pagamento!');
        return;
    }
    
    if (metodoPagamento === 'dinheiro') {
        const total = parseFloat(cart.getTotal());
        if (valorDinheiro < total) {
            alert('❌ Insira um valor maior ou igual ao total!');
            return;
        }
    }
    
    // Fechar modal de pagamento e abrir modal de resumo
    document.getElementById('modalPagamento').classList.add('hidden');
    mostrarResumoPedido(); // ← CHAMANDO FUNÇÃO DE RESUMO
}

// Função: Fechar modal de pagamento
function fecharModalPagamento() {
    document.getElementById('modalPagamento').classList.add('hidden');
    metodoPagamento = null;
    valorDinheiro = 0;
}

// Função: Enviar pedido
// Função: Enviar pedido (nova - só abre modal de pagamento)
function enviarPedido() {
    abrirModalPagamento();
}

// Função: Mostrar resumo do pedido com pagamento
function mostrarResumoPedido() {
    const itens = cart.getCartData();
    
    if (itens.length === 0) {
        alert('❌ Adicione itens ao carrinho!');
        return;
    }

    // Gerar mensagem WhatsApp COM informações de pagamento
    const mensagemWhatsapp = gerarMensagemWhatsapp(itens);
    
    // Preencher modal com resumo
    const modal = document.getElementById('modalPedido');
    const resumo = document.getElementById('pedidoResumo');
    
    let html = '<strong>Seu Pedido:</strong>\n';
    itens.forEach(item => {
        html += `
        <div class="mb-2 pb-2 border-b">
            <div class="font-semibold">${item.quantidade}x ${item.nome}</div>
            <div class="text-sm text-gray-600">R$ ${(item.preco * item.quantidade).toLocaleString('pt-BR', {minimumFractionDigits: 2})}</div>
            ${item.observacoes ? `<div class="text-xs text-blue-600 italic">${item.observacoes}</div>` : ''}
        </div>
        `;
    });
    
    html += `
    <div class="mt-3 pt-3 border-t-2 font-bold text-lg">
        Total: R$ ${cart.getTotal().replace('.', ',')}
    </div>
    
    <div class="mt-2 pt-2 border-t-2">
        <div class="text-sm font-semibold text-gray-700">Pagamento: ${getNomePagamento(metodoPagamento)}</div>
        ${metodoPagamento === 'dinheiro' ? `<div class="text-sm text-gray-700">Troco: R$ ${calcularValorTroco().toLocaleString('pt-BR', {minimumFractionDigits: 2})}</div>` : ''}
    </div>
    
    <div class="mt-2 p-3 bg-blue-50 rounded text-xs text-blue-700">
        <strong>Mensagem WhatsApp:</strong>
        <div id="mensagemPreview" class="mt-2 whitespace-pre-wrap bg-white p-2 rounded border">${mensagemWhatsapp}</div>
    </div>
    `;
    
    resumo.innerHTML = html;
    modal.classList.remove('hidden');
}

// Função: Gerar mensagem formatada (ATUALIZADA com pagamento)
function gerarMensagemWhatsapp(itens) {
    let mensagem = "🛒 *PEDIDO DO CARDÁPIO*\n\n";
    
    itens.forEach((item, index) => {
        mensagem += `${index + 1}. *${item.quantidade}x ${item.nome}*\n`;
        mensagem += `   R$ ${(item.preco * item.quantidade).toLocaleString('pt-BR', {minimumFractionDigits: 2})}\n`;
        if (item.observacoes) {
            mensagem += `   📝 ${item.observacoes}\n`;
        }
        mensagem += "\n";
    });
    
    mensagem += "━━━━━━━━━━━━━━━━━━\n";
    mensagem += `*TOTAL: R$ ${cart.getTotal().replace('.', ',')}*\n`;
    mensagem += "━━━━━━━━━━━━━━━━━━\n\n";
    
    // ← NOVO: Adicionar forma de pagamento
    mensagem += `*💳 Forma de Pagamento:* ${getNomePagamento(metodoPagamento)}\n`;
    
    if (metodoPagamento === 'dinheiro') {
        const troco = calcularValorTroco();
        mensagem += `*💵 Dinheiro:* R$ ${valorDinheiro.toLocaleString('pt-BR', {minimumFractionDigits: 2})}\n`;
        mensagem += `*🔄 Troco:* R$ ${troco.toLocaleString('pt-BR', {minimumFractionDigits: 2})}\n`;
    }
    
    mensagem += "\nObrigado! 😊";
    
    return mensagem;
}

// Função: Converter código de pagamento para nome legível
function getNomePagamento(metodo) {
    const nomes = {
        'pix': '📱 PIX',
        'credito': '💳 Cartão de Crédito',
        'debito': '🏧 Cartão de Débito',
        'dinheiro': '💵 Dinheiro'
    };
    return nomes[metodo] || 'Não especificado';
}

// Função: Calcular valor do troco
function calcularValorTroco() {
    if (metodoPagamento !== 'dinheiro') return 0;
    const total = parseFloat(cart.getTotal());
    return Math.max(0, valorDinheiro - total);
}

// Função: Copiar mensagem para clipboard (ATUALIZADA)
function copiarMensagemWhatsapp() {
    const preview = document.getElementById('mensagemPreview');
    const texto = preview.textContent;
    
    navigator.clipboard.writeText(texto).then(() => {
        alert('✅ Mensagem copiada!\n\nAgora é só colar no WhatsApp!');
    }).catch(() => {
        // Fallback para navegadores antigos
        const textarea = document.createElement('textarea');
        textarea.value = texto;
        document.body.appendChild(textarea);
        textarea.select();
        document.execCommand('copy');
        document.body.removeChild(textarea);
        alert('✅ Mensagem copiada!');
    });
}

// Função: Enviar direto pelo WhatsApp
function enviarWhatsapp() {
    const itens = cart.getCartData();
    const mensagem = gerarMensagemWhatsapp(itens);
    
    // ⚠️ CONFIGURE AQUI: Mude "552140000000" para seu número
    // Formato: 55 (Brasil) + DDD (2 dígitos) + número (8 ou 9 dígitos)
    // Exemplo: 5521987654321 (WhatsApp do Rio de Janeiro)
    const numeroWhatsapp = "5514997971011"; 

    // Codificar mensagem para URL
    const mensagemCodificada = encodeURIComponent(mensagem);
    
    // Link do WhatsApp
    const linkWhatsapp = `https://wa.me/${numeroWhatsapp}?text=${mensagemCodificada}`;
    
    // Abrir em nova aba
    window.open(linkWhatsapp, '_blank');
}

// Função: Confirmar pedido no servidor
function confirmarPedidoServidor() {
    const itens = cart.getCartData();
    
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '/pedidos';
    
    form.innerHTML = `
        <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').content}">
        <input type="hidden" name="itens" value='${JSON.stringify(itens)}'>
        <input type="hidden" name="observacoes" value="${itens[0]?.observacoes || ''}">
    `;
    
    document.body.appendChild(form);
    fecharModal();
    form.submit();
}

// Função: Fechar modal
function fecharModal() {
    const modal = document.getElementById('modalPedido');
    modal.classList.add('hidden');
}

// Inicializar ao carregar
document.addEventListener('DOMContentLoaded', function() {
    console.log('📦 Estado do Carrinho:');
    console.log('Cart:', cart.cart);
    console.log('Preços:', cart.precos);
    console.log('Total:', cart.getTotal());
    console.log('Item Count:', cart.getItemCount());
    
    cart.updateUI();
    console.log('✅ Carrinho inicializado.');
});
</script>
@endsection
