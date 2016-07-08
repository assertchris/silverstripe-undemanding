Install:

```sh
$ composer require silverstripe/undemanding
```

Add listener to `phpunit.xml`:

```xml
<listeners>
    ... your other listeners
    <listener class="SilverStripe\Undemanding\Listener" file="undemanding/code/Listener.php" />
</listeners>
```

Create a test:

```php
use SilverStripe\Undemanding\Tester;

class ExampleTest extends FunctionalTest
{
    use Tester;

    /**
     * @test
     */
    public function siteTitleDisplayed()
    {
        $this->visit()->see("Your Site Name");
    }
}
```
