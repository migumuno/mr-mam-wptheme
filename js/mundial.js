function getMatches(path, teams, filter) {
    moment.locale('es');
    const json = path + '/json/mundialv1.json';

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
        
        printMatches(matchesToShow, path, teams);
    }
}

function getTeams(path, callback, print = true, filter) {
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
}

function printMatches(matches, path, teams) {
    const timeline = jQuery('#matches .matches--wrapper');
    timeline.empty();
    var date = undefined;
    let count = 0;

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

function printTeams(teams, path) {
    const teamsDiv = jQuery('header .header--teams');

    teams.forEach(team => {
        teamsDiv.append('<li onclick="getTeams(\''+ path +'\', getMatches, false, {\'key\': \'nombre\', \'value\': \''+team.nombre+'\'});" class="header--teams__team '+ team.img +' tooltip"><img src="'+ path + '/img/equipos-mundial/' + team.img +'.png" alt="'+ team.nombre +'"><span class="hidden-xs hidden-sm hidden-md tooltiptext">'+ team.nombre +'</span></li>');
    });
}