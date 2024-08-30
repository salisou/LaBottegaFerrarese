security:

# https://symfony.com/doc/current/security.html#registering-the-user-hashing-passwords

password_hashers:
Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface: "auto"

# https://symfony.com/doc/current/security.html#loading-the-user-the-user-provider

providers: # Ogni sezione protetta della tua applicazione necessita di un concetto di utente. # Il provider di utenti carica gli utenti da qualsiasi archivio # (ad esempio il database) # in base a un "identificativo utente" # (ad esempio l'indirizzo e-mail dell'utente);
users*in_memory: { memory: null } # Non restituisci nessun utnet, perché è vuota
firewalls: # Verifica l'identità dell'utente
dev:
pattern: ^/(*(profiler|wdt)|css|images|js)/
security: false
main:
lazy: true
provider: users_in_memory

      # activate different ways to authenticate
      # https://symfony.com/doc/current/security.html#the-firewall

      # https://symfony.com/doc/current/security/impersonating_user.html
      # switch_user: true

# Easy way to control access for large sections of your site

# Note: Only the _first_ access control that matches will be used

access_control: # - { path: ^/admin, roles: ROLE_ADMIN } # - { path: ^/profile, roles: ROLE_USER }

when@test:
security:
password_hashers: # By default, password hashers are resource intensive and take time. This is # important to generate secure password hashes. In tests however, secure hashes # are not important, waste resources and increase test times. The following # reduces the work factor to the lowest possible values.
Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface:
algorithm: auto
cost: 4 # Lowest possible value for bcrypt
time_cost: 3 # Lowest possible value for argon
memory_cost: 10 # Lowest possible value for argon
