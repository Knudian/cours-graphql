import gql from 'graphql-tag';
import { Book } from '../../../model/book';

const request = gql`mutation bookInput($input: BookInput) {
    bookInput(input: $input) {
      title
      releaseDate
      type
      price
      author {
        lastName
        firstName
        birthDate
      }
    }
  }
`;

export function addBook(book: Book) {
    return {
        mutation: request,
        variables: {
            input: {
                title: book.title,
                type:  book.type,
                releaseDate: book.releaseDate,
                price: book.price,
                author: {
                    lastName: book.author.lastName,
                    firstName: book.author.firstName,
                    birthDate: '1930-06-03'
                }
            }
        }
    };
}
