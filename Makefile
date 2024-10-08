# Makefile pour les opérations Doctrine et Symfony

# Nom de la base de données
DB_NAME := autorent

# Commandes
DROP_DB := symfony console doctrine:database:drop -f
CREATE_DB := symfony console doctrine:database:create
SCHEMA_UPDATE := symfony console doctrine:schema:update -f
LOAD_FIXTURES := symfony console doctrine:fixtures:load -n

# Cibles

drop:
	@echo "Dropping database $(DB_NAME)..."
	$(DROP_DB)

create:
	@echo "Creating database $(DB_NAME)..."
	$(CREATE_DB)

schema-update:
	@echo "Updating schema..."
	$(SCHEMA_UPDATE)

fixtures:
	@echo "Loading fixtures..."
	$(LOAD_FIXTURES)

# Cible pour tout faire
full: drop create schema-update fixtures


