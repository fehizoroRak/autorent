# Makefile pour les opérations Doctrine et Symfony

# Nom de la base de données
DB_NAME := autorent

# Commandes
DROP_DB := symfony console doctrine:database:drop --force
CREATE_DB := symfony console doctrine:database:create
MAKE_MIGRATION := symfony console make:migration
MIGRATE := symfony console doctrine:migrations:migrate
LOAD_FIXTURES := symfony console doctrine:fixtures:load

# Cibles

drop:
	@echo "Dropping database $(DB_NAME)..."
	$(DROP_DB)

create:
	@echo "Creating database $(DB_NAME)..."
	$(CREATE_DB)

make-migration:
	@echo "Generating new migration file..."
	$(MAKE_MIGRATION)

migrate:
	@echo "Applying migrations..."
	$(MIGRATE)

fixtures:
	@echo "Loading fixtures..."
	$(LOAD_FIXTURES)

# Cible pour tout faire
full: drop create make-migration migrate fixtures

# Cible pour afficher les commandes disponibles
help:
	@echo "Usage:"
	@echo "  make drop             - Drop the database"
	@echo "  make create           - Create the database"
	@echo "  make make-migration   - Generate a new migration file"
	@echo "  make migrate          - Apply migrations"
	@echo "  make fixtures         - Load all fixtures"
	@echo "  make full             - Drop, create, generate migration, apply migrations, and load all fixtures"
	@echo "  make help             - Show this help message"
