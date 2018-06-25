'use strict';
var teams, matches, groups = [];

/**
 * (ASYNC) Init the mundial functionality
 * @param {string} path 
 */
async function init_mundial(path) {

    // Set the teams
    await getTeams(path);

    // Set the matches
    await getMatches(path);

    // Set matches' results
    await setMatchesResults();

    // Set groups
    await getGroups(teams, matches, path);
}

async function start_mundial(path) {
    // Set the time to es
    moment.locale('es');

    // Show the teams
    await printTeams(path);

    // Show the matches
    await printMatches(path);

    // Hide the loader
    jQuery('.loader').css({'display': 'none'});
}

/**
 * (ASYNC) Get teams
 * @param {string} path 
 * @param {function} callback 
 * @param {boolean} print 
 * @param {object} filter 
 */
async function getTeams(path) {
    const json = path + '/json/equipos_mundial.json';

    // Get teams
    var request = await fetch(json);
    teams = await request.json();
}

/**
 * (ASYNC) Get all the matches
 * @param {string} path 
 * @param {array} teams
 */
async function getMatches(path, teams) {
    const json = path + '/json/mundialv12.json';

    // Get matches
    var request = await fetch(json);
    matches = await request.json();
}

/**
 * (ASYNC) Set matches' results from external API
 */
async function setMatchesResults() {
    const json = 'https://world-cup-json.herokuapp.com/matches';

    var request = await fetch(json);
    var results = await request.json();

    results.forEach(result => {
        if( result.status == 'in progress' || result.status == 'completed' ) {
            // Busco el partido y le asigno el resultado
            for (let index = 0; index < matches.length; index++) {
                if( matches[index].code == result.fifa_id ) {
                    matches[index].golesE1 = result.home_team.goals;
                    matches[index].golesE2 = result.away_team.goals;
                }
            }
        }
    });
}

/**
 * (ASYNC) Get the groups
 */
async function getGroups() {
    const groupsNames = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];

    // Set groups objects and asign name and team array
    groupsNames.forEach(group => {
        groups.push({"nombre": group, "equipos": []});
    });
    
    // Go through the teams
    teams.forEach(team => {
        let count = 0;

        // Go through the groups to set teams to corresponding groups
        groups.forEach((group) => {
            if( group.nombre == team.grupo ) {
                // Set to the team name, image and results
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
        // Go through the groups and check if match's group and group are the same
        for(let i = 0; i < groups.length; i++) {
            if(match.grupo == groups[i].nombre) {
                // Go through the teams and check if match's team 1 and group's team are equal
                for(let j = 0; j < groups[i].equipos.length; j++) {
                    // Busco el equipo 1
                    if( match.equipo1 == groups[i].equipos[j].nombre && match.golesE1 !== "" ) {
                        // Set the results
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
                    // Go through the teams and check if match's team 2 and group's team are equal
                    } else if( match.equipo2 == groups[i].equipos[j].nombre && match.golesE2 !== "" ) {
                        // Set the results
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
            if(a.pts == b.pts) {
                return a.dg < b.dg;
            } else {
                return a.pts < b.pts;
            }
        } );
    }
}

/**
 * Print the groups
 * @param {string} path 
 */
async function printGroups(path) {
    const groupsDiv = jQuery('#groups .groups--wrapper');
    const matchesDiv = jQuery('#matches .matches--wrapper');
    var html = '';

    groupsDiv.empty();
    matchesDiv.empty();

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
        let count = 1;
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
 * Print matches
 * @param {string} path
 */
async function printMatches(path, filteredMatches) {
    const timeline = jQuery('#matches .matches--wrapper');
    const groupsDiv = jQuery('#groups .groups--wrapper');
    var date = undefined;
    let count = 0;
    var matchesToShow;

    timeline.empty();
    groupsDiv.empty();

    if( typeof(filteredMatches) !== 'undefined' ) {
        matchesToShow = filteredMatches;
    } else {
        matchesToShow = matches;
    }

    matchesToShow.forEach(match => {
        count++;
        let matchDate = moment(match.fecha, 'DD-MM-YYYY');
        const groupsNames = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];
        let fase = '';
        let equipo1Img = '';
        let equipo2Img = '';

        // Get the match object corresponding first team
        let equipo1 = teams.find(team => {
            return team.nombre == match.equipo1;
        });
        if( equipo1 !== undefined ) {
            equipo1Img = `<img src="${path}/img/equipos-mundial/${equipo1.img}.png" width="35px" alt="${match.equipo1}">`;
        }

        // Get the match object corresponding second team
        let equipo2 = teams.find(team => {
            return team.nombre == match.equipo2;
        });
        if( equipo2 !== undefined ) {
            equipo2Img = `<img src="${path}/img/equipos-mundial/${equipo2.img}.png" width="35px" alt="${match.equipo2}">`;
        }

        // Define the phase prefix in case group
        if( groupsNames.indexOf(match.grupo) !== -1 ) {
            fase = 'Grupo ';
        }

        // In case the date change, add the corresponding HTML
        if( date === undefined || matchDate.diff(date, 'days') > 0 ) {
            date = matchDate;
            timeline.append('<div class="matches__date"><span class="matches__date--'+ matchDate.format('DD') + matchDate.format('MM') + '">'+ matchDate.format('dddd DD') +' de '+ matchDate.format('MMMM') +'</span></div>');
        }

        // Start with match item
        let html = '<article class="row matches__item">';
        
        // In case even
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
        // In case odd
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
 * Filter the matches and print them
 * @param {string} path 
 * @param {object} filter 
 */
async function printFilteredMatches(path, filter) {
    var matchesToShow = [];

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

    await printMatches(path, matchesToShow);
}

/**
 * Print the teams
 * @param {array} teams 
 * @param {string} path 
 */
async function printTeams(path) {
    const teamsDiv = jQuery('header .header--teams');
    teamsDiv.empty();

    teams.forEach(team => {
        teamsDiv.append('<li data-country="'+team.nombre+'" class="header--teams__team '+ team.img +' tooltip"><img src="'+ path + '/img/equipos-mundial/' + team.img +'.png" alt="'+ team.nombre +'"><span class="hidden-xs hidden-sm hidden-md tooltiptext">'+ team.nombre +'</span></li>');
    });
}