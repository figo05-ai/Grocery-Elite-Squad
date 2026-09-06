# Application Architecture

## Overall Architecture
This project follows a pragmatic Clean Architecture approach, tailored for Laravel. The application is divided into core business domains rather than purely technical folders (like throwing all controllers together regardless of feature).

## Layers
1. **Presentation (HTTP)**: Handles incoming requests, validation, and formats responses.
2. **Application (Services)**: Contains the orchestration logic, use cases, and business rules.
3. **Domain (Models/Entities)**: Contains the core entities (Eloquent models), value objects, and domain logic.
4. **Infrastructure**: Handles external integrations (Stripe, third-party APIs), database specific implementations, and external services.

## Domain Boundaries
The application is split into the following domains:
- **Auth**: Registration, login, OTP verification, password resets.
- **User**: Profile management, addresses, favorite meals, notification settings, loyalty points.
- **Catalog**: Meals, categories, subcategories, reviews, offers, smart lists.
- **Order**: Cart management, order creation, tracking, payment processing (Stripe).
- **Support**: Chatbot, contact forms, FAQs.
- **System**: Static pages, data management, dashboard metrics.

## Dependency Direction
Dependencies must always flow inwards toward the Domain:
`Presentation -> Application (Services) -> Domain (Models)`

- The **Domain** must not depend on HTTP, Controllers, Requests, or external SDKs.
- The **Presentation** layer must not contain complex business logic or database queries.

## Responsibilities

### Controllers
Controllers MUST be thin. Their only responsibilities are:
1. Receive the HTTP Request.
2. Delegate to an Application Service.
3. Return an HTTP Response (via a Response class).
*Controllers must not contain validation logic or database queries.*

### Requests
Form Requests handle HTTP input validation and simple authorization (gates). Do not mix complex business rules into Form Requests.

### Responses
Response classes format the application data into the required JSON structure. They isolate presentation logic from the controllers.

### Services
Services represent meaningful application operations and use cases (e.g., `CreateOrderService`, `ResetPasswordService`). Do NOT create generic, multi-purpose "God" services (like `UserService` with 30 methods).

### Domain (Models)
Eloquent Models hold relationships, casts, and data persistence logic. Complex cross-model business logic should be extracted to Domain Services.

### Infrastructure
External SDKs (e.g., Stripe) and complex database operations (Repositories, if needed) live here to keep the business core isolated.

## The "ONE FILE = ONE DEDICATED FOLDER" Convention
This project enforces a strict architectural rule: **Every PHP class file must have its own dedicated folder**.

**Correct Structure:**
```
Controllers/
    Auth/
        LoginController/
            LoginController.php
        RegisterController/
            RegisterController.php
```

**Incorrect Structure:**
```
Controllers/
    Auth/
        LoginController.php
        RegisterController.php
```

## Adding a New Feature

### How to create a new Controller
1. Identify the domain and the specific use case.
2. Create a dedicated folder: `app/Http/Controllers/[Domain]/[UseCase]Controller/`.
3. Create the controller class inside, implementing the `__invoke` method.

### How to create a Request
1. Create a dedicated folder: `app/Http/Requests/[Domain]/[UseCase]Request/`.
2. Implement your validation rules.

### How to create a Service
1. Create a dedicated folder: `app/Services/[Domain]/[UseCase]Service/`.
2. Inject dependencies via the constructor and implement an `execute()` method.

### How to create a Response
1. Create a dedicated folder: `app/Http/Responses/[Domain]/[ResponseName]/`.
2. Implement a `make()` method that returns a `JsonResponse`.
