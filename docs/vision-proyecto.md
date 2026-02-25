## Visión general del proyecto

Proyecto de **mapa interactivo del mundo de Hielo y Fuego (canon libros)**, con foco inicial en un MVP de la **Danza de los Dragones**.  
Backend en **Laravel + MySQL**, frontend en **Next.js + Tailwind**, con un **maestre IA** (MCP) que responde preguntas sin spoilers según el punto del timeline.

### Objetivos principales

- Mostrar un **mapa interactivo** (imagen JPG + capas SVG) donde:
  - El usuario se mueve con pan/zoom.
  - En la parte superior hay un **timeline** desde la Era del Amanecer hasta el final conocido.
  - Para el MVP solo se cargan eventos de la **Danza de los Dragones**, pero el modelo debe soportar eras futuras.
- Cada posición del timeline (año + secuencia) muestra:
  - Solo los **eventos activos** en ese momento.
  - Participantes relevantes (personajes, ejércitos, dragones) situados en sus **map locations**.
  - Al hacer clic en un elemento se abre una “pseudo‑wiki” con información del personaje/ejército **hasta ese momento**, sin spoilers.
- Integrar un **agente IA tipo maestre** que:
  - Solo conoce hechos **anteriores o iguales** al `timeline_tick` actual.
  - Puede responder preguntas sobre personajes, eventos, eras, localizaciones, etc.
  - Nunca revela el futuro; si algo aún no ocurre, lo indica (“faltan X años para…” o “no hay registros de…”).

### Decisiones clave de diseño

- **Unidad temporal**:
  - Modelo base: `year` + `sequence_order` (varios eventos por año, ordenados).
  - Se añade un campo entero **`timeline_tick`** para facilitar filtros del tipo “todo hasta este momento”.  
    Ejemplo simple: `timeline_tick = year * 100 + sequence_order`.
- **Scope temporal**:
  - Timeline global desde la Era del Amanecer.
  - MVP: solo datos de la **Danza de los Dragones** (año ~129 AC y alrededores).
  - A futuro se podrán filtrar “sub‑líneas” (p.ej. solo Danza, solo Conquista, etc.).
- **Canon**:
  - Se usa **solo canon de los libros de George R. R. Martin**.
  - Las series HBO irán, si se desean, en líneas de tiempo separadas más adelante.
- **Mapa y localizaciones**:
  - Mapa base: imagen JPG de Poniente.
  - Encima, un SVG con **regiones** y paths.
  - `map_locations` almacena:
    - Coordenadas X/Y obtenidas con un “map picker” en el frontend.
    - Posibles referencias a paths SVG (para regiones / frentes).
  - Se podrán definir varias posiciones dentro de la misma zona (p.ej. “Kings Landing norte/sur”) para no superponer iconos.
- **Eventos y participantes**:
  - Cada “paso” del timeline es un **timeline event** (evento corto), descrito con texto y participantes.
  - Los participantes se modelan de forma **polimórfica**: `entity_type` (`character`, `army`, `dragon`, etc.) + `entity_id`.
  - Los ejércitos se modelan solo cuando **importan en la historia** (no se sigue su vida entre guerras si las fuentes no lo detallan).
  - Para elementos que duren varias secuencias (asedios, ejércitos estacionados, etc.) se podrán usar rangos (`start_sequence_order`, `end_sequence_order`) o equivalentes basados en `timeline_tick`.
- **Estado del mundo vs eventos**:
  - El **mapa** muestra solo lo **relevante del evento actual** (y elementos que estén activos durante un rango de secuencias).
  - A futuro se podría añadir una capa de “presencias” (p.ej. `character_presence`) para que el maestre sepa dónde está alguien aunque no participe en eventos visibles, pero **no es obligatorio para el MVP**.
- **Movimiento entre secuencias**:
  - El frontend animará el movimiento:
    - “From”: última posición conocida del participante en una secuencia anterior, o su `home_location` si no existía en el mapa.
    - “To”: la nueva `map_location` enviada por el backend para el evento actual.
  - Si es la primera aparición del participante, simplemente aparece en su posición sin animación previa.

### Multi‑idioma

- El backend almacenará los textos en **un idioma base** (inicialmente español).
- La IA (maestre) será responsable de:
  - Generar el texto “bonito” al abrir la ficha de un item del mapa.
  - Traducir ese texto dinámicamente al idioma de la interfaz cuando sea necesario, **sin traducir nombres propios ni casas**.
- El frontend (Next.js) gestionará las traducciones de **la UI fija** con sus propias herramientas (i18n en frontend).
- No se crean por ahora tablas `_translations`; se evaluará más adelante si hace falta por SEO o por contenido estático.

### Maestre IA y MCP

- El maestre será un **agente local** (modelo gratuito / self‑hosted) orquestado a través de un **MCP**.
- El MCP tendrá acceso a:
  - Endpoints Laravel que devuelven datos estructurados de personajes, eventos, eras, mapas, etc.
  - Nunca acceso directo sin control a toda la BD vía SQL libre.
- El sistema de IA deberá:
  - Respetar `timeline_tick` para filtrar siempre “hechos hasta el momento”.
  - Usar un tono de **maestre**: formal, didáctico, sin metaconversación técnica.
  - Explicar si algo está en el futuro (“faltan X años para…”) o no está registrado.

### Infraestructura

- Backend Laravel desplegado en un **VPS**, expuesto como **API**.
- Frontend Next.js desplegado idealmente en **Vercel**, consumiendo los endpoints del backend.
- Se prevé usar **Redis + colas** para:
  - Cargas pesadas.
  - Precálculo de estados de timeline.
  - Tareas de IA (generación/caché de textos del maestre y wiki contextual).

### Próximos pasos backend

- Definir y crear los modelos base (Eras, TimelineEvents, EventParticipants, Characters, Houses, Armies, Dragons, MapLocations, etc.) con sus migraciones.
- Exponer controladores API básicos (CRUD) para esas entidades.
- Diseñar endpoints específicos para:
  - `GET /timeline/{tick}/map-state`
  - `GET /entity/{type}/{id}?until_tick=...`
- Más adelante, definir herramientas concretas del MCP para el maestre IA usando estos endpoints.

