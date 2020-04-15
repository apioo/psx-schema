public static class Human {
    private int firstName;
    public void setFirstName(int firstName) {
        this.firstName = firstName;
    }
    public int getFirstName() {
        return this.firstName;
    }
}

public static class Student extends Human {
    private int matricleNumber;
    public void setMatricleNumber(int matricleNumber) {
        this.matricleNumber = matricleNumber;
    }
    public int getMatricleNumber() {
        return this.matricleNumber;
    }
}


public static class Map<T> {
    private int totalResults;
    private T[] entries;
    public void setTotalResults(int totalResults) {
        this.totalResults = totalResults;
    }
    public int getTotalResults() {
        return this.totalResults;
    }
    public void setEntries(T[] entries) {
        this.entries = entries;
    }
    public T[] getEntries() {
        return this.entries;
    }
}

public static class RootSchema {
    private Map<Student> students;
    public void setStudents(Map<Student> students) {
        this.students = students;
    }
    public Map<Student> getStudents() {
        return this.students;
    }
}
