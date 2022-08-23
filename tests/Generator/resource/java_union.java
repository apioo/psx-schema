public class Creature {
    private String kind;
    public void setKind(String kind) {
        this.kind = kind;
    }
    public String getKind() {
        return this.kind;
    }
    public Map<String, Object> toMap() {
        Map<String, Object> map = new HashMap<>();
        map.put("kind", this.kind);
        return map;
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
    public Map<String, Object> toMap() {
        Map<String, Object> map = new HashMap<>();
        map.put("firstName", this.firstName);
        return map;
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
    public Map<String, Object> toMap() {
        Map<String, Object> map = new HashMap<>();
        map.put("nickname", this.nickname);
        return map;
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
    public Map<String, Object> toMap() {
        Map<String, Object> map = new HashMap<>();
        map.put("union", this.union);
        map.put("intersection", this.intersection);
        map.put("discriminator", this.discriminator);
        return map;
    }
}
