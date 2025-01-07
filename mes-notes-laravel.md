# NOTES CONCERNANT LARAVEL

## Seeders et factories

1. **Les seeders** : Les seeders sont utilisés pour remplir la base de données avec des données initiales ou nécessaires pour le fonctionnement de l'application, comme les rôles d'utilisateur, les paramètres par défaut, ou tout autre contenu statique.
   use Illuminate\Database\Seeder;

```php
class RoleSeeder extends Seeder
{
    public function run()
    {
        DB::table('roles')->insert([
            ['name' => 'Admin'],
            ['name' => 'User'],
        ]);
    }
}
```

2. Les **factories** : Les factories servent à générer rapidement des données fictives (mock data) pour tester ton application ou simuler des scénarios.

```php
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => bcrypt('password'),
        ];
    }
}
```

3. Le lien entre les deux
   Les seeders peuvent utiliser les factories pour créer des données de manière dynamique.
   Tu peux donc voir les seeders comme un script de remplissage global et les factories comme un outil pour générer des données modulables !

## API Resource en Laravel

```bash
php artisan make:resource StudentResource
```

Elle génère une classe située dans le dossier app/Http/Resources, qui est utilisée pour transformer les modèles ou collections de données en réponses JSON formatées de manière cohérente pour les API.

- Transformer les données avant de les renvoyer dans une APIF
- Abstraction des données sensibles
- Facilité de formatage

## La méthode __invoke

Dans une classe PHP (comme dans le contrôleur Laravel ici) permet de définir la classe comme "invocable". Cela signifie qu'on peut l'appeler directement comme si c'était une fonction, sans spécifier de méthode explicitement.

Pourquoi utiliser __invoke dans Laravel ?
Dans Laravel, la méthode __invoke est particulièrement utile lorsqu'une classe contrôleur gère une seule action. Au lieu d'avoir une méthode spécifique comme index, store, ou update, vous définissez toute la logique dans __invoke.
