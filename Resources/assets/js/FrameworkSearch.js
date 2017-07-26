export class SearchForm {
  constructor () {
    this.form = $('[data-form-class="SearchForm"]')
    this.initSearch()
  }

  initSearch () {
    let $searchField = $('input[name=term]', this.form)
    let route = $(this.form).attr('action') + '.json'

    $searchField.autocomplete({
      position: {
        using (position, elements) {
          let newPosition = {
            left: position.left,
            top: position.top + $searchField.outerHeight(),
            bottom: 'auto',
            margin: 0
          }
          elements.element.element.css(newPosition)
        }
      },
      source (request, response) {
        return $.ajax({
          type: 'GET',
          url: route,
          data: {term: request.term},
          success (data) {
            let items = []
            for (let value of Array.from(data.data.results)) {
              items.push(
                {
                  value
                }
              )
            }
            return response(items)
          }
        })
      },
      select (e, ui) {
        e.preventDefault()
        if (ui.item.value.route !== null) {
          document.location = ui.item.value.route
        } else if (ui.item.value.value !== null) {
          return ui.item.value.value
        } else {
          return ui.item.label
        }
      },
      focus (e, ui) {
        e.preventDefault()
        return $(e.target).val(ui.item.value.title)
      }
    })

    $searchField.each((idx, element) => {
      $(element).data('ui-autocomplete')._renderItem = this.renderItem
    })
  }

  renderItem (ul, item) {
    $('<li>')
      .append(
        $('<a>').append(
          item.value.title +
          '<small class="muted"> (' + item.value.bundle + ')</small>'
        )
      )
      .appendTo(ul)
  }
}

window.searchForm = new SearchForm()
