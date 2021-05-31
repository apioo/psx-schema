public class Human {
    private String firstName;
    public void setFirstName(String firstName) {
        this.firstName = firstName;
    }
    public String getFirstName() {
        return this.firstName;
    }
}

public class Student extends Human {
    private String matricleNumber;
    public void setMatricleNumber(String matricleNumber) {
        this.matricleNumber = matricleNumber;
    }
    public String getMatricleNumber() {
        return this.matricleNumber;
    }
}

public class StudentMap extends Map<Student> {
}

public class Map<T> {
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

public class RootSchema {
    private StudentMap students;
    public void setStudents(StudentMap students) {
        this.students = students;
    }
    public StudentMap getStudents() {
        return this.students;
    }
}
