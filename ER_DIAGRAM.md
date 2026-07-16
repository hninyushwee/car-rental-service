```mermaid
erDiagram
    USERS ||--o{ BOOKINGS : "has"
    USERS ||--o{ PAYMENTS : "makes"
    USERS ||--o{ INQUIRIES : "submits"
    USERS ||--o{ PROMOTION_USAGES : "uses"
    USERS ||--o{ NOTIFICATIONS : "receives"

    CATEGORIES ||--o{ VEHICLES : "categorizes"
    BRANDS ||--o{ VEHICLES : "manufactures"

    VEHICLES ||--o{ BOOKING_ITEMS : "rented in"
    VEHICLES }o--o{ DRIVERS : "qualified through"
    DRIVERS ||--o{ BOOKING_ITEMS : "assigned to"
    DRIVERS }o--|| DRIVING_LICENSE_TYPES : "has"

    BOOKINGS ||--o{ BOOKING_ITEMS : "contains"
    BOOKINGS ||--o{ PROMOTION_USAGES : "applied to"
    BOOKINGS ||--o{ PAYMENTS : "payable" [poly]
    NOTIFICATIONS ||--o{ BOOKINGS : "notifiable" [poly]

    PROMOTIONS ||--o{ PROMOTION_USAGES : "redeemed in"

    USERS {
        bigint id PK
        string name
        string email UK
        string phone
        string image "nullable"
        timestamp email_verified_at "nullable"
        string password
        timestamp deleted_at "soft delete"
        timestamp created_at
        timestamp updated_at
    }

    CATEGORIES {
        bigint id PK
        string name UK
        timestamp created_at
        timestamp updated_at
    }

    BRANDS {
        bigint id PK
        string name UK
        timestamp created_at
        timestamp updated_at
    }

    VEHICLES {
        bigint id PK
        foreignKey category_id FK
        foreignKey brand_id FK
        string model
        integer year
        string color
        integer capacity
        decimal price_per_day
        string location
        text description
        json images
        integer total_stock
        integer available_stock
        timestamp deleted_at "soft delete"
        timestamp created_at
        timestamp updated_at
    }

    DRIVERS {
        bigint id PK
        string name
        string email UK
        string phone
        string license_number
        string license_expiry_date
        foreignKey driving_license_type_id FK "nullable"
        string image "nullable"
        text address "nullable"
        enum status "available | on_trip | off_duty"
        timestamp deleted_at "soft delete"
        timestamp created_at
        timestamp updated_at
    }

    DRIVING_LICENSE_TYPES {
        bigint id PK
        string type UK
        decimal price
        string image "nullable"
        timestamp created_at
        timestamp updated_at
    }

    DRIVER_VEHICLE {
        foreignKey driver_id FK "(composite PK)"
        foreignKey vehicle_id FK "(composite PK)"
        boolean is_primary
        timestamp assigned_at
    }

    BOOKINGS {
        bigint id PK
        foreignKey user_id FK
        string booking_number UK
        enum status "pending | confirmed | active | completed | cancelled"
        datetime cancelled_at "nullable"
        text cancellation_reason "nullable"
        decimal car_deposit_snapshot
        decimal driver_deposit_snapshot
        decimal subtotal_price
        decimal discount_amount
        decimal total_price
        timestamp deleted_at "soft delete"
        timestamp created_at
        timestamp updated_at
    }

    BOOKING_ITEMS {
        bigint id PK
        foreignKey booking_id FK
        foreignKey vehicle_id FK "nullable"
        foreignKey driver_id FK "nullable"
        boolean has_driver
        integer quantity
        datetime start_date
        datetime end_date
        datetime actual_return_date "nullable"
        text pickup_location
        text dropoff_location
        decimal vehicle_daily_rate
        decimal driver_daily_rate
        text notes "nullable"
        timestamp created_at
        timestamp updated_at
    }

    PAYMENTS {
        bigint id PK
        foreignKey user_id FK
        string payable_type "morph"
        bigint payable_id "morph"
        enum payment_method "cash | kpay | wavepay | card | bank_transfer"
        string transaction_ref UK
        string image "nullable"
        enum status "pending | paid | failed"
        datetime payment_date "nullable"
        decimal amount
        timestamp created_at
        timestamp updated_at
    }

    PROMOTIONS {
        bigint id PK
        string code UK
        text description "nullable"
        enum discount_type "percentage | fixed_amount"
        decimal discount_value
        decimal min_spend
        decimal max_discount "nullable"
        datetime start_date
        datetime end_date
        enum status "active | expired | disabled"
        timestamp created_at
        timestamp updated_at
    }

    PROMOTION_USAGES {
        bigint id PK
        foreignKey promotion_id FK
        foreignKey user_id FK
        foreignKey booking_id FK UK
        decimal discount_applied
        datetime used_at
        timestamp created_at
        timestamp updated_at
    }

    INQUIRIES {
        bigint id PK
        foreignKey user_id FK "nullable"
        string phone "nullable"
        string email
        string subject
        text message
        text admin_response "nullable"
        enum status "open | resolved"
        datetime resolved_at "nullable"
        timestamp created_at
        timestamp updated_at
    }

    NOTIFICATIONS {
        bigint id PK
        foreignKey user_id FK
        enum type "booking | payment | promotion | system | inquiry"
        string title
        text message
        boolean is_read
        string notifiable_type "nullable morph"
        bigint notifiable_id "nullable morph"
        timestamp created_at
        timestamp updated_at
    }

    DEPOSIT_SETTINGS {
        bigint id PK
        string service_key UK
        enum deposit_type "fixed | percentage"
        decimal amount
        boolean is_active
        timestamp created_at
        timestamp updated_at
    }
```
