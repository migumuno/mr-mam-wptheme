/**
 * Obtiene los equipos de futbol y llama al callback, y si print es true, los imprime
 * @param {string} path 
 * @param {function} callback 
 * @param {boolean} print 
 * @param {object} filter 
 */
async function getTeams(path, callback, print = true, filter) {
    const json = path + '/json/equipos_mundial.json';
    const teams_json = json;
    var request = new XMLHttpRequest();

    request.open( 'GET', teams_json );
    request.responseType = 'json';
    request.send();
    request.onload = () => {
        const teams = request.response;

        // Si pido imprimir, imprimo los equipos
        if( print ) {
            printTeams(teams, path);
        }

        // Llamo al callback
        callback(path, teams, filter);
    }

    return true;
}

/**
 * Obtiene todos los partidos de futbol y ejecuta su impresión
 * @param {string} path 
 * @param {array} teams 
 * @param {object} filter 
 */
function getMatches(path, teams, filter) {
    moment.locale('es');
    const json = path + '/json/mundialv4.json';

    const matches_json = json;
    var request = new XMLHttpRequest();
    var matchesToShow;

    request.open( 'GET', matches_json );
    request.responseType = 'json';
    request.send();
    request.onload = () => {
        const matches = request.response;

        // Compruebo si se ha pasado un filtro
        if(filter === undefined) {
            matchesToShow = matches;
        } else {
            // Si hay filtro, lo aplico para obtener los equipos a mostrar
            matchesToShow = [];
            matches.forEach(match => {
                if(filter.key == 'nombre') {
                    if(match.equipo1 == filter.value || match.equipo2 == filter.value ) {
                        matchesToShow.push(match);
                    }
                } else {
                    if(match[filter.key] == filter.value) {
                        matchesToShow.push(match);
                    }
                }
            });
        }

        if(filter !== undefined && filter.show == "groups") {
            getGroups(teams, matches, path);
        } else {
            printMatches(matchesToShow, path, teams);
        }
    }
}

/**
 * Obtiene los grupos y los imprime
 * @param {array} teams 
 * @param {array} matches 
 */
function getGroups(teams, matches, path) {
    var groups = [];
    const groupsNames = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];

    // Recorro los nombres de los grupos para crear los grupos
    groupsNames.forEach(group => {
        groups.push({"nombre": group, "equipos": []});
    });
    
    // Recorro los equipos para añadirlos en los grupos que correspondan
    teams.forEach(team => {
        let count = 0;

        // Recorro los grupos para asignar el equipo
        groups.forEach((group) => {
            if( group.nombre == team.grupo ) {
                // Asigno el equipo con el nombre indicado y creo los resultados a 0
                groups[count].equipos.push({
                    "nombre": team.nombre,
                    "img": team.img,
                    "pj": 0,
                    "v": 0,
                    "e": 0,
                    "d": 0,
                    "gf": 0,
                    "gc": 0,
                    "dg": 0,
                    "pts": 0
                });
            }
            count++;
        });
    });

    matches.forEach(match => {
        // Recorro los grupos y compruebo que coincidan con el grupo del partido
        for(let i = 0; i < groups.length; i++) {
            if(match.grupo == groups[i].nombre) {
                // Recorro los equipos y compruebo que coincidan con el equipo 1 o 2
                for(let j = 0; j < groups[i].equipos.length; j++) {
                    // Busco el equipo 1
                    if( match.equipo1 == groups[i].equipos[j].nombre && match.golesE1 !== "" ) {
                        // Asigno resultados
                        groups[i].equipos[j].pj++;
                        groups[i].equipos[j].gf += match.golesE1;
                        groups[i].equipos[j].gc += match.golesE2;

                        if( match.golesE1 > match.golesE2 ) {
                            groups[i].equipos[j].v++;
                        } else if( match.golesE1 < match.golesE2 ) {
                            groups[i].equipos[j].d++;
                        } else {
                            groups[i].equipos[j].e++;
                        }

                        groups[i].equipos[j].dg = groups[i].equipos[j].gf - groups[i].equipos[j].gc;
                        groups[i].equipos[j].pts = (groups[i].equipos[j].v * 3) + groups[i].equipos[j].e;
                    // Busco el equipo 2
                    } else if( match.equipo2 == groups[i].equipos[j].nombre && match.golesE2 !== "" ) {
                        // Asigno resultados
                        groups[i].equipos[j].pj++;
                        groups[i].equipos[j].gf += match.golesE2;
                        groups[i].equipos[j].gc += match.golesE1;

                        if( match.golesE2 > match.golesE1 ) {
                            groups[i].equipos[j].v++;
                        } else if( match.golesE2 < match.golesE1 ) {
                            groups[i].equipos[j].d++;
                        } else {
                            groups[i].equipos[j].e++;
                        }

                        groups[i].equipos[j].dg = groups[i].equipos[j].gf - groups[i].equipos[j].gc;
                        groups[i].equipos[j].pts = (groups[i].equipos[j].v * 3) + groups[i].equipos[j].e;
                    }
                }
                
            }
        }
    });

    for(let i = 0; i < groups.length; i++) {
        groups[i].equipos.sort( (a, b) => {
            return a.dg < b.dg;
        } );
    }

    printGroups(groups, path);
}

/**
 * Imprime los grupos
 * @param {array} groups 
 * @param {string} path 
 */
function printGroups(groups, path) {
    const groupsDiv = jQuery('#groups .groups--wrapper');
    const matchesDiv = jQuery('#matches .matches--wrapper');
    var html = '';

    matchesDiv.empty();
    groupsDiv.empty();

    groups.forEach(g => {
        // Añado la clase contenedora del grupo
        html += '<div class="groups--group group'+g.nombre+'">';
        // Añado el título y la clase contenedora de la tabla
        html += '<div class="groups--group__title">Grupo '+g.nombre+'</div><div class="groups--group__table">';
        // Añado el inicio de la tabla
        html += `<table>
        <tbody>
            <tr>
                <th>Equipo</th>
                <th>PJ</th>
                <th>V</th>
                <th>E</th>
                <th>D</th>
                <th>GF</th>
                <th>GC</th>
                <th>DG</th>
                <th>Pts</th>
            </tr>`;
            
        // Añado los equipos del grupo
        count = 1;
        g.equipos.forEach(t => {
            html += `<tr>
                <td><span>${count}</span> <img src="${path}/img/equipos-mundial/${t.img}.png" width="20px" alt="${t.nombre}"> ${t.nombre}</td>
                <td>${t.pj}</td>
                <td>${t.v}</td>
                <td>${t.e}</td>
                <td>${t.d}</td>
                <td>${t.gf}</td>
                <td>${t.gc}</td>
                <td>${t.dg}</td>
                <td>${t.pts}</td>
            </tr>`;

            count++;
        });

        // Cierro la tabla
        html += '</tbody></table>';
        // Cierro la calse contenedora de la tabla
        html += '</div>';
        // Cierro la calse contenedora del grupo
        html += '</div>';
    });
    groupsDiv.append(html);
}

/**
 * Imprime los partidos
 * @param {array} matches 
 * @param {string} path 
 * @param {array} teams 
 */
function printMatches(matches, path, teams) {
    const timeline = jQuery('#matches .matches--wrapper');
    const groupsDiv = jQuery('#groups .groups--wrapper');
    var date = undefined;
    let count = 0;

    groupsDiv.empty();
    timeline.empty();

    matches.forEach(match => {
        count++;
        let matchDate = moment(match.fecha, 'DD-MM-YYYY');
        const groups = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];
        let fase = '';
        let equipo1Img = '';
        let equipo2Img = '';

        // Obtengo el objeto del equipo correspondiente referente al primero
        let equipo1 = teams.find(team => {
            return team.nombre == match.equipo1;
        });
        if( equipo1 !== undefined ) {
            equipo1Img = `<img src="${path}/img/equipos-mundial/${equipo1.img}.png" width="35px" alt="${match.equipo1}">`;
        }

        // Obtengo el objeto del equipo correspondiente referente al segundo
        let equipo2 = teams.find(team => {
            return team.nombre == match.equipo2;
        });
        if( equipo2 !== undefined ) {
            equipo2Img = `<img src="${path}/img/equipos-mundial/${equipo2.img}.png" width="35px" alt="${match.equipo2}">`;
        }

        if( groups.indexOf(match.grupo) !== -1 ) {
            fase = 'Grupo ';
        }

        if( date === undefined || matchDate.diff(date, 'days') > 0 ) {
            date = matchDate;
            timeline.append('<div class="matches__date"><span class="matches__date--'+ matchDate.format('DD') + matchDate.format('MM') + '">'+ matchDate.format('dddd DD') +' de '+ matchDate.format('MMMM') +'</span></div>');
        }
        let html = '<article class="row matches__item">';
        
        if( count % 2 == 0 ) {
            html += `<div class="col-sm-6 matches__item--empty">
                <div class="matches__item--empty__mark"></div>
            </div>`;
            html += `<div class="col-sm-6 matches__item--content">
                <div class="matches__item--content__mark"></div>
                <div class="matches__item--content__text">
                    <b>${match.hora}</b>
                    <h2>${equipo1Img} ${match.equipo1} ${match.golesE1} - ${match.golesE2} ${equipo2Img} ${match.equipo2}</h2>
                    <ul class="matches__item--content__text--info">
                        <li class="matches__item--content__text--info__channels">${match.canales}</li>
                        <li class="matches__item--content__text--info__group">${fase} ${match.grupo}</li>
                        <li class="matches__item--content__text--info__group">${match.donde}</li>
                        <li class="matches__item--content__text--info__group">Partido ${count}</li>
                    </ul>
                </div>
            </div>`;
        } else {
            html += `<div class="col-sm-6 matches__item--content">
                <div class="matches__item--content__mark"></div>
                <div class="matches__item--content__text">
                    <b>${match.hora}</b>
                    <h2>${equipo1Img} ${match.equipo1} ${match.golesE1} - ${match.golesE2} ${equipo2Img} ${match.equipo2}</h2>
                    <ul class="matches__item--content__text--info">
                        <li class="matches__item--content__text--info__channels">${match.canales}</li>
                        <li class="matches__item--content__text--info__group">${fase} ${match.grupo}</li>
                        <li class="matches__item--content__text--info__group">${match.donde}</li>
                        <li class="matches__item--content__text--info__group">Partido ${count}</li>
                    </ul>
                </div>
            </div>`;
            html += `<div class="col-sm-6 matches__item--empty">
                <div class="matches__item--empty__mark"></div>
            </div>`;
        } 
            
        html += '</article>';

        timeline.append(html);
    });
}

/**
 * Imprime los equipos
 * @param {array} teams 
 * @param {string} path 
 */
function printTeams(teams, path) {
    const teamsDiv = jQuery('header .header--teams');
    teamsDiv.empty();

    teams.forEach(team => {
        teamsDiv.append('<li onclick="getTeams(\''+ path +'\', getMatches, false, {\'key\': \'nombre\', \'value\': \''+team.nombre+'\'});" class="header--teams__team '+ team.img +' tooltip"><img src="'+ path + '/img/equipos-mundial/' + team.img +'.png" alt="'+ team.nombre +'"><span class="hidden-xs hidden-sm hidden-md tooltiptext">'+ team.nombre +'</span></li>');
    });
}