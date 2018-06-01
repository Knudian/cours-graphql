import gql from 'graphql-tag';

export function bookList(page: Number, perPage: Number = 20) {
    return gql`{
        bookList(page: ${page}, perPage: ${perPage}) {
            id
            title
            type
            price
            releaseDate
            author {
                id
                lastName
                firstName
                birthDate
            }
        }
    }`;
}
