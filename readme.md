Add this to your `phpunit.xml`:

```xml
<listeners>
    ... your other listeners
    <listener class="SilverStripe\Undemanding\Listener" file="undemanding/src/Listener.php" />
</listeners>
```
