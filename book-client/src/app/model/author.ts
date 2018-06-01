export class Author {
    public id: Number;
    public firstName: string;
    public lastName: string;
    public birthDate: string;

    constructor() {}

    populateWith(data: object): this {
        this.id = data['id'];
        this.firstName = data['firstName'];
        this.lastName = data['lastName'];
        this.birthDate = data['birthDate'];
        return this;
    }
}
