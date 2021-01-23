public class Creature {
    private String kind;
    public void setKind(String kind) {
        this.kind = kind;
    }
    public String getKind() {
        return this.kind;
    }
}

public class Human extends Creature {
    private String firstName;
    public void setFirstName(String firstName) {
        this.firstName = firstName;
    }
    public String getFirstName() {
        return this.firstName;
    }
}

public class Animal extends Creature {
    private String nickname;
    public void setNickname(String nickname) {
        this.nickname = nickname;
    }
    public String getNickname() {
        return this.nickname;
    }
}

public class Union {
    private Object union;
    private Object intersection;
    private Object discriminator;
    public void setUnion(Object union) {
        this.union = union;
    }
    public Object getUnion() {
        return this.union;
    }
    public void setIntersection(Object intersection) {
        this.intersection = intersection;
    }
    public Object getIntersection() {
        return this.intersection;
    }
    public void setDiscriminator(Object discriminator) {
        this.discriminator = discriminator;
    }
    public Object getDiscriminator() {
        return this.discriminator;
    }
}
