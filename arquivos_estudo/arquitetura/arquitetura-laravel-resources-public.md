# Arquitetura de Assets no Laravel (resources vs public)

Este documento explica de forma simples como o **Laravel organiza
arquivos de front‑end** (HTML, CSS e JavaScript) e como eles chegam até
o navegador.

------------------------------------------------------------------------

# 1. Estrutura básica do projeto Laravel

Um projeto típico do Laravel possui uma estrutura parecida com esta:

    meu-projeto
    │
    ├── app
    ├── routes
    ├── database
    │
    ├── resources
    │   ├── views
    │   ├── css
    │   └── js
    │
    └── public
        ├── css
        ├── js
        └── index.php

As duas pastas mais importantes para o **front‑end** são:

-   `resources`
-   `public`

------------------------------------------------------------------------

# 2. Diferença entre resources e public

  Pasta       Quem usa
  ----------- ----------------------
  resources   Desenvolvedor
  public      Navegador do usuário

### Regra de ouro

O **navegador só consegue acessar arquivos dentro da pasta `public`.**

Todo o resto do projeto fica protegido.

Isso é feito por **segurança**, para que ninguém consiga acessar:

-   código do backend
-   rotas
-   lógica da aplicação
-   banco de dados

------------------------------------------------------------------------

# 3. O que o navegador realmente vê

Quando alguém acessa o site:

    https://seusite.com

O servidor normalmente aponta diretamente para:

    /public

Então, para o navegador, a estrutura parece ser apenas:

    site
    │
    ├── css
    ├── js
    ├── imagens
    └── index.php

Ele **não consegue ver**:

-   `resources`
-   `app`
-   `database`
-   `routes`

------------------------------------------------------------------------

# 4. O que fica dentro de resources

A pasta `resources` é onde o **desenvolvedor escreve o código do
front‑end**.

Exemplo:

    resources
    │
    ├── views
    │   └── home.blade.php
    │
    ├── css
    │   └── app.css
    │
    └── js
        └── app.js

Aqui ficam:

-   Views Blade
-   CSS original
-   JavaScript original

------------------------------------------------------------------------

# 5. Processo de build (Vite)

Ferramentas modernas como **Vite** pegam os arquivos de:

    resources/css
    resources/js

e geram arquivos otimizados em:

    public/css
    public/js

Exemplo:

    resources/css/app.css
           ↓
    public/css/app.css

Agora o navegador consegue carregar esses arquivos.

------------------------------------------------------------------------

# 6. Como o HTML carrega os arquivos

No Laravel normalmente usamos Blade com Vite:

    @vite(['resources/css/app.css', 'resources/js/app.js'])

Ou diretamente:

    <link rel="stylesheet" href="/css/app.css">

O navegador então baixa:

    public/css/app.css

------------------------------------------------------------------------

# 7. Fluxo completo

Fluxo de desenvolvimento:

    DESENVOLVEDOR
    ↓
    resources/css/app.css
    resources/js/app.js
    resources/views/home.blade.php

    BUILD (Vite)
    ↓
    public/css/app.css
    public/js/app.js

    NAVEGADOR
    ↓
    carrega arquivos da pasta public

------------------------------------------------------------------------

# 8. Analogia simples

Podemos pensar assim:

    resources = cozinha do restaurante
    public = balcão de entrega

O cliente **nunca entra na cozinha**, ele apenas recebe o prato pronto.

------------------------------------------------------------------------

# 9. Dica importante

Arquivos que devem ficar em `public`:

-   imagens
-   favicon
-   css compilado
-   javascript compilado
-   fontes

Exemplo correto:

    public/images/logo.png

Uso no HTML:

    <img src="/images/logo.png">

------------------------------------------------------------------------

# Conclusão

O Laravel separa:

-   **Código de desenvolvimento (`resources`)**
-   **Arquivos públicos (`public`)**

Isso melhora:

-   segurança
-   organização
-   performance do site

------------------------------------------------------------------------

Documento criado para estudo de arquitetura básica do Laravel.
