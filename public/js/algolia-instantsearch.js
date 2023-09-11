(function () {
    const searchClient = algoliasearch('BL28J6C7AL', '3adf9bf2ad5e28f52abe1d1cedda3065');

    const search = instantsearch({
        indexName: 'products',
        searchClient,
        routing: true
    });

    search.addWidgets([
        instantsearch.widgets.searchBox({
            container: '#searchbox',
            placeholder: 'Search for products',
        }),

        instantsearch.widgets.hits({
            container: '#hits',
            templates: {
                item: (hit, { html, components }) => html`
                    <a  href="${window.location.origin}/shop/${hit.slug}">
                        <div>
                          <img src="${window.location.origin}/storage/${hit.image}" align="left" style="max-width: 70px" alt="${hit.name}" />

                          <div class="hit-name">
                            ${components.Highlight({ hit, attribute: 'name' })}
                          </div>

                          <div class="hit-details">
                            ${components.Highlight({ hit, attribute: 'details' })}
                          </div>
                          <div class="hit-price">$${(hit.price /100).toFixed(2)}</div>

                        </div>
                    </a>
                  `,
                empty(results, { html }) {
                    return html`No results for <q>${results.query}</q>`;
                },
            },
        }),


        instantsearch.widgets.stats({
            container: '#stats',

        }),

        instantsearch.widgets.pagination({
            container: '#pagination',
        }),

        instantsearch.widgets.refinementList({
            container: '#refinement-list',
            attribute: 'categories',
            sortBy: ['name:asc'],
        }),

    ]);

    search.start();

})();


