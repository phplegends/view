#PHPLegends\View

A biblioteca View do PHPLegends provê uma maneira de manipular views do PHP facilmente, podendo te oferecer a opção de incluir blocos de códigos, e herança e reutilização de templates.


#Instalação

Para instalar o PHPLegends\View, você precisa utilizar o Composer.

Para instalar execute:

```bash
composer require phplegends/views
``` 

#Exemplo
Após instalar, você precisar utilizar o `Factory` para poder criar as suas views. O `Factory` por sua vez, precisa do `Finder` para definição do local e as extensões de arquivo que serão utilizadas como views.

Veja um exemplo simples de como carregar arquivos `phtml` ou `php`:

```php
use PHPLegends\View\Factory;
use PHPLegends\View\Finder;


$finder = new Finder(['phtml' => null, 'php' => null], '/caminho/das/views');

$factory = new Factory($finder);

```


Após as definições acima, você definiu que as suas views terão as extensões `phtml` e `php` e que elas serão procuradas pelo `Finder` a partir da pasta `/caminho/das/views`.


Se você tiver a estrutura de diretório abaixo, você poderia fazer a criação das views da seguintes forma:

```
caminhos
        /das
            /views
                  layout.phtml
                  home/
                       hello.phtml
                    

```


Para criar a view, utilize o método `Factory::create`. Uma instância de `View` será retornada.

```php
$view = $factory->create('home/hello');
```

No arquivo `/caminho/das/views/home/hello.phtml`, defina:

```html
<div>Hello!</div>
```


Para renderizar o arquivo, você pode utilizar o método `View::render()`, ou simplesmente fazer o cast de `View` para `string`.

Veja:

```php
echo $view; // View::__toString é invocado

// ou 

echo $view->render();

```

#Estendendo Views

Uma das coisas que pode tornar o processo de desenvolvimento mais lento é a repetição de código. Se você precisa utilizar aquele template que terão menus, rodapés e imagens repetindo em várias páginas, você pode solucionar esse problema através dessa biblioteca.

Por exemplo, podemos unir duas views, para criar uma só apresentação para o usuário final.

Altere o arquivo `home/hello` para o seguinte:

```php
<?php $this->extend('layout') ?>

<?php $this->section('content') ?>

Essa é a minha primeira view com layout no PHPLegends\View

<?php $this->endSection() ?>
```

Em seguida, defina no seu arquivo `layout.phtml` a seguinte definição

```php
<!DOCTYPE html>
<html>
<head>
    <title>Hello PHPLegends!</title>
</head>
<body>
    <div class="content">
        <?php echo $this->getSection('content') ?>
    </div>
</body>
</html>
```


Ao invocar a view `home/hello`, o conteúdo definido em `$this->section('content')` será renderizado dentro do trecho definido em `layout.phtml`, `echo $this->getSection('content')`.

O resultado retornado será o seguinte:

```html
<!DOCTYPE html>
<html>
<head>
    <title>Hello PHPLegends!</title>
</head>
<body>
    <div class="content">

        Essa é a minha primeira view com layout no PHPLegends\View

    </div>
</body>
</html>
```

**Nota**: Se a utilização de `section` for necessária apenas para um pequeno trecho de código, você pode utilizar o segundo parâmetro desse método, ao invés de chamar `endSection` ao final.


Exemplo:

```php
<?php $this->extend('layout') ?>

<?php $this->section('content', 'Essa é a minha primeira view com layout no PHPLegends\View') ?>
```

Assim, você evita que `ob_start` seja invocado internamente.



#PHPLegends\View\Context

A classe `Context` nada mais é que o contexto do `$this` no qual você está utilizando a sua `view`. Ou seja, quando você invoca `$this->getSection('content')` dentro de uma view, na verdade você está invocando um método de uma instância de `Context`.

Alguns métodos de `Context` são:
* section         - inicia uma "section"
* endSection      - finaliza um bloco de "section"
* appendSection   - Adiciona um techo numa "section" existente
* includes        - Inclui uma view parcial dentro da view atual.
* extend          - Invoca o layout principal para uma view


#Passando dados para a View

Para passar uma variável para uma `View`, você precisa definir um `array` com os índices desejados, para que sejam acessíveis como variáveis no seu template.

Veja um exemplo:

```php

$view = $factory->create('home/hello', ['autor' => 'Wallace de Souza']);

echo $view;

```

Com a seguinte definição abaixo...

```html
<div>Meu nome é <?php echo $autor ?></div>
```

... você terá o seguinte resultado:

```html
<div>Meu nome é Wallace de Souza</div>
```

#Definindo valores Globais


Você pode desejar compartilhar um determinado valor global com todas as views que você utilizar.

Existe uma maneira muito simples de fazer isso, que é utilizando o método `Factory::share`.

Veja:

```php

  $factory->share('OBJECT', new stdClass);

  $view1 = $factory->create('home/hello');
  $view2 = $factory->create('home/support');

  echo $view1;
  echo $view2;

```

No exemplo acima, todas as `views` (inclusive as views pais) teriam acessível dentro dos seus escopos a variável `$OBJECT`.