<p align="center"><img src="https://consulta.pe/img/logo_consulta_pe.png"> </p>

<p align="center">

# Paquete Oficial para Laravel 
### Para Laravel < 5.5, use el SDK [RENIEC-PHP](https://github.com/tecactus/reniec-php) o [SUNAT-PHP](https://github.com/tecactus/sunat-php)!!

## Instalación
Instalar usando composer:

```bash
   composer require consulta/laravel
```

O agregar la siguiente línea a tu archivo composer.json:

```json
   "require": {
       ...
       "consulta/laravel": "1.*"
       ...
   }
```


## Reglas de validación Disponibles

 - [`IsValidDNIDigit`](#isvaliddnidigit)
 - [`IsValidDNI`](#isvaliddni)
 - [`IsValidRUC`](#isvalidruc)
 
 
### `IsValidDNIDigit`

Determina si el dígito de verificación corresponde al dni ingresado

```php
// in a `FormRequest` 

public function rules()
{
    return [
        'dni' => "required|size:8",
        'validation_digit' => ['required','size:1',new IsValidDNIDigit($this->dni)],
    ];
}
```
### `IsValidDNI`
Determina si el número de DNI ingresado pertenece a un peruano mayor de edad

```php
// in a `FormRequest` 

public function rules()
{
    return [
        'dni' => ['required','size:1',new IsValidDNI()],
    ];
}
```

### `IsValidRUC`

Determina si el número de RUC ingresado pertenece a una empresa registrada en la Superintendencia Nacional de Aduanas y de Administración Tributaria (SUNAT).


#### parámetros:
 
La clase IsValidRUC admite un único parametro, cuando es ``true`` valida además que la empresa esté activa y habida.  


```php
// in a `FormRequest` 

public function rules()
{
    return [
        'ruc' => ['required','size:11',new IsValidRUC(true)],
    ];
}
```

## Docs
Para mayor información consulta la documentación de [consulta.pe](https://consulta.pe/) para:

 - [Identidad de personas](https://consulta.pe/identidad-personas)
 - [Datos Corporativos](https://consulta.pe/datos-corporativos)

