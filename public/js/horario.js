/**
 * Decide en el navegador que cuentas estan disponibles.
 *
 * Existe porque la decision no puede tomarse en el servidor cuando hay cache de
 * pagina: el HTML se genera una vez y se sirve durante dias, asi que el horario
 * quedaria congelado en el momento en que se guardo la copia.
 *
 * En modo servidor este script no decide nada; solo publica el estado que ya
 * calculo PHP, para que el evento exista siempre y los widgets de terceros
 * puedan escucharlo igual en los dos modos.
 */
(function () {
    'use strict';

    var datos = window.whatsappFlotanteHorario;

    if (!datos) {
        return;
    }

    /**
     * Fecha y hora en la zona del SITIO, nunca en la del visitante.
     *
     * Se usa Intl con el nombre de la zona en lugar del desfase que podria
     * imprimir el servidor: con la pagina cacheada durante una semana, un
     * desfase fijo deja de ser valido en cuanto entra o sale el horario de
     * verano. El navegador conoce la base de datos de zonas y lo resuelve.
     */
    function ahoraEnElSitio() {
        try {
            var partes = {};

            new Intl.DateTimeFormat('en-CA', {
                timeZone: datos.zona,
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            }).formatToParts(new Date()).forEach(function (p) {
                partes[p.type] = p.value;
            });

            var hora = partes.hour;

            // Algunos motores devuelven 24 en lugar de 00 para la medianoche.
            if (hora === '24') {
                hora = '00';
            }

            return {
                fecha: partes.year + '-' + partes.month + '-' + partes.day,
                hora: hora + ':' + partes.minute,
                // Mediodia para que el dia de la semana no baile con el cambio horario.
                dia: new Date(+partes.year, +partes.month - 1, +partes.day, 12).getDay()
            };
        } catch (e) {
            // Navegador sin soporte de zonas horarias con nombre. Se recurre al
            // desfase impreso por el servidor: menos exacto tras un cambio de
            // hora, pero sigue siendo la hora del sitio y no la del visitante.
            var d = new Date(Date.now() + (datos.desfase * 1000));
            var dosCifras = function (n) { return (n < 10 ? '0' : '') + n; };

            return {
                fecha: d.getUTCFullYear() + '-' + dosCifras(d.getUTCMonth() + 1) + '-' + dosCifras(d.getUTCDate()),
                hora: dosCifras(d.getUTCHours()) + ':' + dosCifras(d.getUTCMinutes()),
                dia: d.getUTCDay()
            };
        }
    }

    /**
     * Mismo criterio que is_account_available() en PHP: la hora de fin no cuenta.
     * Las cadenas "HH:MM" se comparan como texto, que con ese formato fijo
     * equivale a compararlas como horas.
     */
    function estaAbierta(horarios, ahora) {
        if (!horarios || !horarios.length) {
            return true;
        }

        for (var i = 0; i < horarios.length; i++) {
            var h = horarios[i];

            if (h.d.indexOf(ahora.dia) === -1) {
                continue;
            }

            if (ahora.hora >= h.i && ahora.hora < h.f) {
                return true;
            }
        }

        return false;
    }

    var ultimoEstado = null;

    function publicar(abierto, cuentas) {
        var estado = { abierto: abierto, cuentas: cuentas, modo: datos.modo };

        window.whatsappFlotanteEstado = estado;

        // Solo se reemite cuando cambia, pero siempre se emite la primera vez,
        // abra o cierre: hay integraciones que dependen de saber que esta cerrado.
        if (ultimoEstado === null || ultimoEstado !== abierto) {
            ultimoEstado = abierto;
            document.dispatchEvent(new CustomEvent('whatsappFlotante:estado', { detail: estado }));
        }
    }

    function evaluar() {
        if (datos.modo !== 'cliente') {
            publicar(!!datos.abierto, datos.cuentas || 0);
            return;
        }

        var ahora = ahoraEnElSitio();
        var festivo = datos.festivos.indexOf(ahora.fecha) !== -1;
        var items = document.querySelectorAll('[data-wf-horarios]');
        var visibles = 0;

        for (var i = 0; i < items.length; i++) {
            var horarios;

            try {
                horarios = JSON.parse(items[i].getAttribute('data-wf-horarios'));
            } catch (e) {
                horarios = [];
            }

            var disponible = !festivo && estaAbierta(horarios, ahora);

            items[i].classList.toggle('wf-oculto', !disponible);

            if (disponible) {
                visibles++;
            }
        }

        var boton = document.getElementById('whatsapp-flotante-btn');
        var modal = document.getElementById('whatsapp-flotante-modal');

        if (boton) {
            boton.classList.toggle('wf-oculto', visibles === 0);
        }

        // Si se cierra con el modal abierto, se cierra tambien el modal.
        if (modal && visibles === 0) {
            modal.style.display = 'none';
        }

        publicar(visibles > 0, visibles);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', evaluar);
    } else {
        evaluar();
    }

    // Una pestana abierta durante horas debe enterarse de que se ha hecho la hora
    // de cierre sin esperar a que el visitante recargue.
    if (datos.modo === 'cliente') {
        setInterval(evaluar, 60000);
    }
})();
