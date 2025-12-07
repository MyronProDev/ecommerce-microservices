### E-commerce Microservices (Symfony, Docker, RabbitMQ)

This repository contains a small, event-driven e-commerce demo built with Symfony 6.4. It is split into independent services and wired together via RabbitMQ and an Nginx API gateway. Each service has its own database and shares common value objects via a local `shared-bundle` package.

### Architecture
- API Gateway: Nginx routes external traffic to the services.
- Products Service: Manages products (CRUD subset). On create, dispatches a domain event `ProductCreated` and can publish integration events (AMQP/Messenger).
- Orders Service: Consumes events and manages orders (skeleton shown for `OrderCreatedMessage`).
- Message Broker: RabbitMQ for async, pub/sub integration between services.
- Databases: Separate PostgreSQL instances per service (`products-db`, `orders-db`).
- Shared Bundle: Reusable code (e.g., `Money` value object) shared across services via Composer path repo.

### Key Tech
- Symfony 6.4, Doctrine ORM 3, Symfony Messenger (AMQP), PostgreSQL, RabbitMQ, Docker Compose

### Local Development
- Compose file: `docker-compose.yaml`
- Environment: `.env` in the repo root controls ports and credentials
- Bring everything up:
```bash
docker compose up --build
```
- Default ports (from `.env`):
    - API Gateway: `http://localhost:${API_GATEWAY_PORT}` (default 8080)
    - RabbitMQ: AMQP `${RABBITMQ_PORT}` (5672), Management UI `${RABBITMQ_MANAGEMENT_PORT}` (15672)
    - Products DB `${PRODUCTS_DB_PORT}` (5432), Orders DB `${ORDERS_DB_PORT}` (5433)

### Products API (examples)
- Create product: `POST /api/products`
- List products: `GET /api/products`
- Get product by id: `GET /api/products/{id}`

On successful creation, the products service flushes the entity and dispatches `ProductCreated` (with `eventId` and `occurredAt`) to the internal event bus, enabling pub/sub propagation via Messenger/RabbitMQ.

### Notes
- Containers mount service directories for live reload during development.
- Each service exposes its own network and connects to the default network for cross-service communication through the gateway and broker.
