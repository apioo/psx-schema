import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;
import java.util.List;
public class Creature {
    private String kind;
    @JsonSetter("kind")
    public void setKind(String kind) {
        this.kind = kind;
    }
    @JsonGetter("kind")
    public String getKind() {
        return this.kind;
    }
}

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;
import java.util.List;
public class Human extends Creature {
    private String firstName;
    @JsonSetter("firstName")
    public void setFirstName(String firstName) {
        this.firstName = firstName;
    }
    @JsonGetter("firstName")
    public String getFirstName() {
        return this.firstName;
    }
}

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;
import java.util.List;
public class Animal extends Creature {
    private String nickname;
    @JsonSetter("nickname")
    public void setNickname(String nickname) {
        this.nickname = nickname;
    }
    @JsonGetter("nickname")
    public String getNickname() {
        return this.nickname;
    }
}

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;
import java.util.List;
public class Union {
    private Object union;
    private Object intersection;
    private Object discriminator;
    @JsonSetter("union")
    public void setUnion(Object union) {
        this.union = union;
    }
    @JsonGetter("union")
    public Object getUnion() {
        return this.union;
    }
    @JsonSetter("intersection")
    public void setIntersection(Object intersection) {
        this.intersection = intersection;
    }
    @JsonGetter("intersection")
    public Object getIntersection() {
        return this.intersection;
    }
    @JsonSetter("discriminator")
    public void setDiscriminator(Object discriminator) {
        this.discriminator = discriminator;
    }
    @JsonGetter("discriminator")
    public Object getDiscriminator() {
        return this.discriminator;
    }
}
