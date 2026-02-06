# GiveAll (PocketMine-MP API 5)

Plugin simple para la última versión de PocketMine-MP que permite dar un item a **todas** las personas conectadas.

## Comando

- `/giveall <item> [cantidad]`

### Ejemplos

- `/giveall diamond 3`
- `/giveall bread 16`
- `/giveall iron_sword`

## Permiso

- `giveall.command` (por defecto: `op`)

## Notas

- Si el inventario de un jugador está lleno, los items sobrantes se sueltan en el suelo en su posición.
- La cantidad máxima por ejecución es `64`.
