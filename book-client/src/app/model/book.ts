import { Author } from './author';

export class Book {
    public id: Number = null;
    public title: string = null;
    public type: string = null;
    public price: Number = null;
    public releaseDate: string = null;
    public author: Author = null;

    constructor() {
        this.author = new Author();
    }

    populateWith(data: object): this {
        this.id = data['id'];
        this.title = data['title'];
        this.type = data['type'];
        this.price = data['price'];
        this.releaseDate = data['releaseDate'];
        this.author.populateWith(data['author']);
        return this;
    }
}
