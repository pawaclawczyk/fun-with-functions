# Object oriented service and function correlation.

I was thinking about relation between object oriented service implementation and its representation in functional approach.
Here is what I came up with.

## Classical object oriented implementation.

```php
class InvoiceCreator
{
    private $grossPrice;

    public function __construct(GrossPrice $grossPrice)
    {
        $this->grossPrice = $grossPrice;
    }

    public function create(Product $product, Money $netPrice)
    {
        return Invoice::with(
            $product,
            $this->grossPrice->calculate($netPrice)
        );
    }
}

interface GrossPrice
{
    public function calculate(Money $netPrice);
}

class PolishGrossPrice implements GrossPrice
{
    public function calculate(Money $netPrice)
    {
        return $netPrice->multiply(1.23);
    }
}

$invoiceCreator = new InvoiceCreator(new PolishGrossPrice());

$invoiceCreator->calculate(Product::named('Teapot'), Money::PLN(100));

// Invoice(Product(Teapot), Money(100 PLN))
```

## Service has one method so it is possible to make it invokeable. But wait, for real it has two methods... the constructor.

```php
class InvoiceCreator
{
    public function __invoke(GrossPrice $grossPrice, Product $product, Money $netPrice)
    {
        return Invoice::with(
            $product,
            $grossPrice($netPrice)
        );
    }
}

interface GrossPrice
{
    public function calculate(Money $netPrice);
}

class PolishGrossPrice implements GrossPrice
{
    public function __invoke(Money $netPrice)
    {
        return $netPrice->multiply(1.23);
    }
}

$invoiceCreator = new InvoiceCreator();
$polishGrossPrice = new PolishGrossPrice();

$invoiceCreator($polishGrossPrice, Product::named('Teapot'), Money::PLN(100));

// Invoice(Product(Teapot), Money(100 PLN))
```

## Now we can make it a function. Sic! We are going to lose typing of things.

```php
function InvoiceCreator(GrossPrice $grossPrice, Product $product, Money $netPrice)
    return Invoice::with(
        $product,
        $this->grossPrice->calculate($netPrice)
    );
}

function PolishGrossPrice(Money $netPrice)
{
    return $netPrice->multiply(1.23);
}

InvoiceCreator(PolishGrossPrice, Product::named('Teapot'), Money::PLN(100));

// Invoice(Product(Teapot), Money(100 PLN))
```

## Let's curry!

```php
function InvoiceCreator(GrossPrice $grossPrice, Product $product, Money $netPrice)
    return Invoice::with(
        $product,
        $this->grossPrice->calculate($netPrice)
    );
}

function PolishGrossPrice(Money $netPrice)
{
    return $netPrice->multiply(1.23);
}

$invoiceCreator = curry(InvoiceCreator);

$polishInvoiceCreator = $invoiceCreator(PolishGrossPrice);

$polishInvoiceCreator(Product::named('Teapot'), Money::PLN(100));

// Invoice(Product(Teapot), Money(100 PLN))
```

## One thing was missed. Gross price holds a state in its implementation. What forces us to create new function definition for every country.

```php
function InvoiceCreator(GrossPrice $grossPrice, Product $product, Money $netPrice)
    return Invoice::with(
        $product,
        $this->grossPrice->calculate($netPrice)
    );
}

function GrossPrice($factor, Money $netPrice)
{
    return $netPrice->multiply($factor);
}

$grossPrice = curry(GrossPrice);
$invoiceCreator = curry(InvoiceCreator);

$polishGrossPrice = $grossPrice(1.23);
$polishInvoiceCreator = $invoiceCreator($polishGrossPrice);

$polishInvoiceCreator(Product::named('Teapot'), Money::PLN(100));

// Invoice(Product(Teapot), Money(100 PLN))
```

## Final thoughts...

If ...
... service has single business method (and the constructor with dependencies),
Then ...
... can be represented as a function,
So ...
... can be curried,
So ...
... can be partially applied,
So ...
... can be reduced to single variable function,
So ...
... can be composed.
Well ...
... probably it is possible to use declarative style of programming using objects - need to check how it could works.

Object with constructor and business method <=> curried function:

```php
(new Object($dependency, $otherDependency))->doThing($argument, $otherArgument);

Function($dependency, $otherDependency)($argument, $otherArgument);
```

Service taken from DI container <=> Partially applied function:
```php
$service = $diContainer->get('service_id');
$service->doThing($argument, $otherArgument);

$partiallyAppliedFunction = Function($dependency, $otherDependency);
$partiallyAppliedFunction->doThing($argument, $otherArgument);
```

## Disclaimer
As I am just crawling in world of functional purity some of my implications can be just wrong and some things can be named improperly.

> Created at 2016-04-19 12:09
>
