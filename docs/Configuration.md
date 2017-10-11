# Configuration

## Supported prooph libraries
<ul>
<li>Event Sourcing (<a href="https://github.com/prooph/event-sourcing">prooph/event-sourcing</a>)</li>
<li>Event Store (<a href="https://github.com/prooph/event-store">prooph/event-store</a>)</li>
<li>PDO Event Store (<a href="https://github.com/prooph/pdo-event-store">prooph/pdo-event-store</a>) - support for projection_manager config</li>
<li>Service Buses (<a href="https://github.com/prooph/service-bus">prooph/service-bus</a>)</li>
<li>More to come (you can wait or contribute :P)</li>
</ul>

## Basics
<p>
	Array structure for configuration is exactly same as in original prooph libraries, because
	extension uses original interop factories from toolbox. 
	However there is some additional config fields (listed below).
</p>

## Example
<p>
	Example basic yml configuration can be found <a href="https://github.com/tomcizek/symfony-prooph/blob/master/tests/SymfonyProophBundle/fixtures/FullTestConfig.yml">here</a>
	or you can see other <a href="https://github.com/tomcizek/symfony-prooph/tree/master/tests/SymfonyProophBundle/fixtures">working test configs</a> for inspiration.
</p>

## Additional config fields

### `event_store`
<p>
	There is additional configuration in `event_store` library configs. 
	It has special key `factory`, where you need to define which factory should be used for given event store:
</p>

```yaml
prooph:
    event_store:
        default:
            factory: Prooph\EventStore\Container\InMemoryEventStoreFactory
            plugins: [...]
```
<p>
    You can define several event stores, but only event store that is defined first, will get alias 
    Prooph\EventStore\EventStore and prooph.event_store.
</p>

### `projection_manager`
<p>
	There is additional configuration in `projection_manager` library configs. 
	It has special key `factory`, where you need to define which factory should be used:
</p>

```yaml
prooph:
    projection_manager:
        default:
            factory: Prooph\EventStore\Pdo\Container\MySqlProjectionManagerFactory
```
<p>
    You can define several projection managers, but only projection manager that is defined first, will get alias 
    Prooph\EventStore\Projection\ProjectionManager and prooph.projection_manager.
</p>
